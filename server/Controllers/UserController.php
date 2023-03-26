<?php

namespace Cursotopia\Controllers;

use Bloom\Hashing\Crypto;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Cursotopia\Models\ImageModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Models\RoleModel;
use Cursotopia\Repositories\UserRepository;
use Exception;

class UserController {
    /**
     * Obtiene un usuario a partir de su id
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getOne(Request $request, Response $response): void {
        // Cualquier usuario puede ver la información de cualquiera, excepto contraseña
        // obviamente
        $id = $request->getParams("id");
        // Validar que el valor del id sea un número entero sin signo
        if (!((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "ID is not valid"
                ]);
            return;
        }

        // Devuelve el usuario si lo encuentra, si no devuelve null
        $user = UserModel::findOneById($id);
        if (!$user) {
            $response
                ->setStatus(404)
                ->json([
                    "status" => false,
                    "message" => "User not found"
                ]);
            return;
        }

        // Decirle que propiedades iran al objeto
        $response->json($user->toObject());
    }

    /**
     * Crea y guarda un nuevo usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void {
        [
            "profilePicture" => $profilePicture,
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
            $response
                ->setStatus(409)
                ->json([
                    "status" => false,
                    "message" => "El correo electrónico esta siendo utilizado por alguien más"
                ]);
            return;
        }

        // Validar que el rol de usuario exista y sea publico (osea que no se pueda
        // poner a el mismo como administrador)
        if (!RoleModel::findOneByIdAndIsPublic($userRole, true)) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Invalid user role"
                ]);
            return;
        }

        // Verificar que la imagen no este tomada
        if (ImageModel::findOneByIdAndNotUserId($profilePicture)) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "The profile picture is taken"
                ]);
            return;
        }

        // Validar que la sessión actual tiene permisos de usar esa imagen
        $session = $request->getSession();
        if ($session->get("profilePicture_id") !== $profilePicture) {
            $session->unset("profilePicture_id");
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Image ID not allowed"
                ]);
            return;
        }

        // Hasheamos la contraseña antes de guardarla en la base de datos
        $hashedPassword = Crypto::bcrypt($password);

        // Creamos el modelo
        $user = new UserModel([
            "profilePicture" => $profilePicture,
            "name" => $name,
            "lastName" => $lastName,
            "birthDate" => $birthDate,
            "userRole" => $userRole,
            "gender" => $gender,
            "email" => $email,
            "password" => $hashedPassword,
        ]);
        
        
        // [x] La foto de perfil debe existir y no debe tenerla alguien más en la BD
        // [x] El id de la foto de perfil debe almacenarse en la sessión
        // [x] El rol debe existir
        // [x] El rol no puede ponerse admin el mismo
        // [x] Validar que el correo electrónico no se repita
        
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
            $session->set("role", $user->getUserRole());
            $session->set("profilePicture", $user->getProfilePicture());

            $response->json([
                "status" => $status,
                "id" => $user->getId(),
                "message" => "The user was sucessfully created"
            ]);
        }
        catch (\Exception $exception) {
            // Algun CONSTRAINT de SQL pudo haberse activado
            die("Todo murio");
        }
    }

    /**
     * Actualiza el perfil de un usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        $session = $request->getSession();
        $sessionUserId = $session->get("id");

        // Solo se puede actualizar tu propio usuario
        if ($id !== $sessionUserId) {
            $response
                ->setStatus(401)
                ->json([
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
        if (!$user) {
            $response
                ->setStatus(409)
                ->json([
                    "status" => false,
                    "message" => "El correo electrónico esta siendo utilizado por alguien más"
                ]);
            return;
        }

        $user = UserModel::findOneById($id);
        if (!$user) {
            $response
                ->setStatus(404)
                ->json([
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
        
        try {
            $status = $user->save();
            if (!$status) {
                $response
                    ->setStatus(400)
                    ->json([
                        "status" => false,
                        "message" => "El usuario no pudo ser actualizado"
                    ]);
                return;
            }
        }
        catch (Exception $ex) {
            $response
                ->setStatus(500)
                ->json([
                    "status" => false,
                    "message" => "Ocurrio un error al actualizar el usuario"
                ]);
        }

        $response->json([
            "status" => true,
            "message" => "El usuario se actualizó éxitosamente"
        ]);
    }

    /**
     * Actualiza la contraseña de un usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function updatePassword(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
        
        // Solo se puede actualizar la contraseña de tu usuario autenticado
        $session = $request->getSession();
        if ($id !== $session->get("id")) {
            $response
                ->setStatus(401)
                ->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
            return;
        }

        $user = UserModel::findOneById($id);
        if (!$user) {
            $response
                ->setStatus(401)
                ->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
            return;
        }

        // Tiene que autenticarse nuevamente para actualizar la contraseña
        $login = $user->login();

        $oldPassword = $request->getBody("oldPassword");
        $newPassword = $request->getBody("newPassword");
        if (!Crypto::verify($login["password"], $oldPassword)) {
            $response
                ->setStatus(401)
                ->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
            return;
        }

        $user
            ->setPassword($newPassword);

        try {
            $status = $user->save();
            if (!$status) {
                $response
                    ->setStatus(400)
                    ->json([
                        "status" => false,
                        "message" => "La contraseña no pudo ser actualizada"
                    ]);
                return;
            }
        }
        catch (Exception $exception) {
            $response
                ->setStatus(500)
                ->json([
                    "status" => false,
                    "message" => "Ocurrio un error al actualizar la contraseña"
                ]);
        }

        $response->json([
            "status" => true,
            "message" => "La contraseña se actualizó éxitosamente"
        ]);
    }

    public function remove(Request $request, Response $response) {
        $response
            ->setStatus(405)
            ->json([
                "status" => false,
                "message" => "Método no permitido"
            ]);
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

    public function getAll(Request $request, Response $response): void {
        $name = $request->getQuery("name");
        
        $session = $request->getSession();
        $role = $session->get("role");

        $userRepository = new UserRepository();
        $users = $userRepository->findAll($name, $role);

        $response->json($users);
    }

}
