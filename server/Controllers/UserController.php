<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Hashing\Crypto;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\ImageModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Models\RoleModel;
use Cursotopia\ValueObjects\Roles;
use DateTime;
use Exception;

class UserController {
    public function loginWeb(Request $request, Response $response): void {
        $response->render("login");
    }

    public function signup(Request $request, Response $response): void {
        $roles = RoleModel::findAllByIsPublic(true);
        $response->render("signup", [ "roles" => $roles ]);
    }

    public function profile(Request $request, Response $response): void {
        $id = $request->getQuery("id");
        if (!Validate::uint($id)) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        $user = UserModel::findById($id);
        if (!$user) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        // Verificar si el usuario somos nosotros o no
        $session = $request->getSession();
        $isMe = false;
        if ($session->get("id") === $user->getId()) {
            $isMe = true;
        }
        
        $response->render("profile", [ 
            "isMe" => $isMe, 
            "user" => $user->toArray() 
        ]);
    }

    public function profileEdition(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");
    
        $user = UserModel::findById($id);
        if (!$user) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        $response->render("profile-edition", [ 
            "user" => $user->toArray()
        ]);
    }

    public function passwordEdition(Request $request, Response $response): void {
        $response->render("password-edition");
    }

    public function blockedUsers(Request $request, Response $response): void {
        $blockedUsers = UserModel::findBlocked();
        $unblockedUsers = UserModel::findUnblocked();

        $response->render("blocked-users", [
            "blockedUsers" => $blockedUsers,
            "users" => $unblockedUsers
        ]);
    }

    public function findBlockedUsers(Request $request, Response $response): void {
        $blockedUsers = UserModel::findBlocked();

        $response->json([
            "status" => true,
            "blockedUsers" => $blockedUsers
        ]);
    }

    public function findUnblockedUsers(Request $request, Response $response): void {
        $unblockedUsers = UserModel::findUnblocked();

        $response->json([
            "status" => true,
            "unblockedUsers" => $unblockedUsers
        ]);
    }

    public function login(Request $request, Response $response): void {
        [
            "email" => $email,
            "password" => $password
        ] = $request->getBody();
        
        $user = UserModel::findOneByEmail($email);
        if (!$user) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "Credenciales incorrectas"
            ]);
            return;
        }
        $user = new UserModel($user);

        $session = $request->getSession();
        if (!Crypto::verify($user->getPassword(), $password)) {
            if ($session->get("loginIntentsEmail") !== $email) {
                $session->set("loginIntentsEmail", $email);
                $session->set("loginIntentsCount", 1);
            }
            else {
                $count = $session->get("loginIntentsCount");
                $session->set("loginIntentsCount", $count + 1);

                if ($session->get("loginIntentsCount") >= 3) {
                    // Deshabilitar cuenta
                    $user->setEnabled(false);
                    $user->save();
                }
            }
            
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "Credenciales incorrectas"
            ]);
            return;
        }

        // TODO:
        // Hay que considerar también que si el usuario esta bloqueado no deberia
        // poder hacer consultas a la base de datos en ningun endpoint
        if (!$user->getEnabled()) {
            $response->json([
                "status" => false,
                "message" => "Tú cuenta esta bloqueada"
            ]);
            return;
        }

        $session->set("id", $user->getId());
        $session->set("role", $user->getRole());
        $session->set("profilePicture", $user->getProfilePicture());

        // Eliminar la información de intentos de login
        $session->unset("loginIntentsEmail");
        $session->unset("loginIntentsCount");

        $response->json([
            "status" => true,
            "message" => "Inicio de sesión éxitoso"
        ]);    
    }

    public function logout(Request $request, Response $response): void {
        $session = $request->getSession();
        $session->destroy();
        $response->redirect("/");
    }

    public function getAll(Request $request, Response $response): void {
        $name = $request->getQuery("name", "");
        $role = $request->getSession()->get("role");

        $users = UserModel::findAll($name, $role);

        $response->json($users);
    }

    public function getAllInstructors(Request $request, Response $response): void {
        $name = $request->getQuery("name", "");

        $users = UserModel::findAllInstructors($name);

        $response->json($users);
    }

    public function getOne(Request $request, Response $response): void {
        // Cualquier usuario puede ver la información de cualquiera, excepto contraseña
        // obviamente
        $id = intval($request->getParams("id"));

        // Devuelve el usuario si lo encuentra, si no devuelve null
        $user = UserModel::findById($id);
        if (!$user) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El usuario no fue encontrado"
            ]);
            return;
        }

        // Decirle que propiedades iran al objeto
        $user->setIgnores([ "password", "enabled", "active", "createdAt", "modifiedAt" ]);
        $response->json($user);
    }

    public function create(Request $request, Response $response): void {
        [
            "imageId" => $imageId,
            "name" => $name,
            "lastName" => $lastName,
            "birthDate" => $birthDate,
            "userRole" => $userRole,
            "gender" => $gender,
            "email" => $email,
            "password" => $password
        ] = $request->getBody();
        
        // Verificar que el correo electrónico no lo este usando alguien más
        if (UserModel::findOneByEmail($email)) {
            $response->setStatus(409)->json([
                "status" => false,
                "message" => "El correo electrónico esta siendo utilizado por alguien más"
            ]);
            return;
        }

        $today = new DateTime();
        $birthdate = new DateTime($birthDate);

        if ($birthdate > $today) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "La fecha de nacimiento no puede ser en el futuro"
            ]);
            return;
        }

        $diff = $today->diff($birthdate);
        $age = $diff->y;

        if ($age < 18) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Debes ser mayor de 18 años para usar nuestro servicio"
            ]);
            return;
        }

        // Validar que el rol de usuario exista y sea publico (osea que no se pueda
        // poner a el mismo como administrador)
        if (!RoleModel::findOneByIdAndIsPublic($userRole, true)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El rol de usuario no es valido"
            ]);
            return;
        }

        // Verificar que la imagen no este tomada
        if (ImageModel::findOneByIdAndNotUserId($imageId)) {
            $response->setStatus(409)->json([
                "status" => false,
                "message" => "La foto de perfil está siendo utilizada"
            ]);
            return;
        }

        // Hasheamos la contraseña antes de guardarla en la base de datos
        $hashedPassword = Crypto::bcrypt($password);

        // Creamos el modelo
        $user = new UserModel([
            "profilePicture" => $imageId,
            "name" => $name,
            "lastName" => $lastName,
            "birthDate" => $birthDate,
            "role" => $userRole,
            "gender" => $gender,
            "email" => $email,
            "password" => $hashedPassword,
        ]);
        
        $userValidator = new Validator($user);
        if (!$userValidator->validate()) {
            $response->json([
                "status" => false,
                "message" => $userValidator->getFeedback()
            ]);
            return;
        }

        try {
            $status = $user->save();

            $session = $request->getSession();
            $session->set("id", $user->getId());
            $session->set("role", $user->getRole());
            $session->set("profilePicture", $user->getProfilePicture());

            $response->setStatus(201)->json([
                "status" => $status,
                "id" => $user->getId(),
                "message" => "El usuario se creó éxitosamente"
            ]);
        }
        catch (Exception $ex) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrio un error al crear el usuario"
            ]);
        }
    }

    public function update(Request $request, Response $response): void {
        try {
            $id = intval($request->getParams("id"));

            $sessionUserId = $request->getSession()->get("id");

            // Solo se puede actualizar tu propio usuario
            if ($id !== $sessionUserId) {
                $response->setStatus(401)->json([
                    "status" => false,
                    "message" => "No autorizado para actualizar el usuario"
                ]);
                return;
            }

            [
                "name" => $name,
                "lastName" => $lastName,
                "email" => $email,
                "birthDate" => $birthDate,
                "gender" => $gender
            ] = $request->getBody();

            $user = UserModel::findOne([
                [ "id", "<>", $id ],
                [ "email", $email ]
            ]);
            if ($user) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El correo electrónico esta siendo utilizado por alguien más"
                ]);
                return;
            }

            $today = new DateTime();
            $birthdate = new DateTime($birthDate);

            if ($birthdate > $today) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "La fecha de nacimiento no puede ser en el futuro"
                ]);
                return;
            }

            $diff = $today->diff($birthdate);
            $age = $diff->y;

            if ($age < 18) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "Debes ser mayor de 18 años para usar nuestro servicio"
                ]);
                return;
            }

            $user = UserModel::findById($id);
            if (!$user) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "El usuario no fue encontrado"
                ]);
                return;
            }

            $user
                ->setName($name)
                ->setLastName($lastName)
                ->setBirthDate($birthDate)
                ->setGender($gender)
                ->setEmail($email);
            
            DB::beginTransaction();
            $status = $user->save();
            DB::commit();
            if (!$status) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "El usuario no pudo ser actualizado"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "El usuario se actualizó éxitosamente"
            ]);
        }
        catch (Exception $ex) {
            if (DB::inTransaction())
                DB::rollBack();
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrio un error al actualizar el usuario"
            ]);
        }
    }

    public function updatePassword(Request $request, Response $response): void {
        try {
            $id = intval($request->getParams("id"));
            
            // Solo se puede actualizar la contraseña de tu usuario autenticado
            $userId = $request->getSession()->get("id");
            if ($id !== $userId) {
                $response->setStatus(401)->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
                return;
            }

            $user = UserModel::findById($id);
            if (!$user) {
                $response->setStatus(401)->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
                return;
            }

            // Tiene que autenticarse nuevamente para actualizar la contraseña
            $login = UserModel::findOneByEmail($user->getEmail());

            $oldPassword = $request->getBody("oldPassword");
            $newPassword = $request->getBody("newPassword");
            if (!Crypto::verify($login["password"], $oldPassword)) {
                $response->setStatus(401)->json([
                    "status" => false,
                    "message" => "Sus credenciales no son correctas"
                ]);
                return;
            }

            $hashedPassword = Crypto::bcrypt($newPassword);
            $user
                ->setPassword($hashedPassword);

            $status = $user->save();
            if (!$status) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "La contraseña no pudo ser actualizada"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "La contraseña se actualizó éxitosamente"
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrio un error al actualizar la contraseña"
            ]);
        }
    }

    public function checkEmailExists(Request $request, Response $response) {
        $email = $request->getBody("email");
        $session = $request->getSession();
        $id = $session->get("id") ?? -1;

        $user = UserModel::findOne([
            [ "id", "<>", $id ],
            [ "email", $email ]
        ]);

        $response->json(!boolval($user));
    }

    public function disableUser(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        // Devuelve el usuario si lo encuentra, si no devuelve null
        $user = UserModel::findById($id);
        if (!$user) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El usuario no fue encontrado"
            ]);
            return;
        }

        if ($user->getRole() === Roles::ADMIN->value) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "No se pueden bloquear administradores"
            ]);
            return;
        }

        $user->setEnabled(false);

        $result = $user->save();
        if (!$result) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => $result
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "El usuario fue bloqueado con éxito"
        ]);
        return;
    }

    public function enableUser(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        // Devuelve el usuario si lo encuentra, si no devuelve null
        $user = UserModel::findById($id);
        if (!$user) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El usuario no fue encontrado"
            ]);
            return;
        }

        $user->setEnabled(true);

        $result = $user->save();
        if (!$result) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => $result
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "El usuario fue desbloqueado con éxito"
        ]);
    }
}
