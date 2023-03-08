<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Cursotopia\Models\UserModel;
use Exception;

use Opis\JsonSchema\Validator as OpisValidator;

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
        // La foto de perfil debe existir y no debe tenerla alguien más en la BD
        // El id de la foto de perfil debe almacenarse en la sessión
        // El rol debe existir
        $body = $request->getBody();

        $opisValidator = new OpisValidator();

        $schema = (object) [
            'type' => 'number'
        ];

        $jsonSchema = <<<'JSON'
        {
            "type": "object",
            "properties": {
                "username": {
                    "type": "string"
                }
            },
            "required": [ "username" ],
            "additionalProperties": false
        }
        JSON;

        $object = json_decode(json_encode($body), false);
        $result = $opisValidator->dataValidation($object, json_decode($jsonSchema, false));

        
        var_dump($result->getErrors());

        return;





        $user = new UserModel($body);

        $userValidator = new Validator($user);
        if (!$userValidator->validate()) {
            $response->json([
                "status" => false,
                "message" => $userValidator->getFeedback()
            ]);
            return;
        }

        $session = $request->getSession();
        if ($session->get("image_id") !== $user->getProfilePicture()) {
            $session->unset("image_id");
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Image ID not allowed"
                ]);
            return;
        }

        try {
            $status = $user->save();

            $session = $request->getSession();
            $session->set("id", $user->getId());
            $session->set("role", $user->getUserRole());

            $response->json([
                "status" => $status,
                "id" => $user->getId(),
                "message" => "The user was sucessfully created"
            ]);
        }
        catch (\PDOException $exception) {
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
        // La foto de perfil se actualiza aparte, el id se mantiene igual solo cambia
        // el contenido
        // El rol de usuario no cambia porque eso seria muy dificil
        // La contraseña se cambia en otro apartado
        $id = $request->getParams("id");
        $body = $request->getBody();
        
        //$session = $request->getSession();
        //$id = $session->get("id");

        $name = $request->getBody("name");
        $lastName = $request->getBody("lastName");
        $gender = $request->getBody("gender");
        $birthDate = $request->getBody("birthDate");
        $email = $request->getBody("email");

        /**
         * $user = UserModel::findOneById($id)
         * if (!$user) {
         *  return 404
         * } 
         * 
         * $userModel
         *  ->setName() ...
         * 
         * $userModel->save()
         */

        $response->json([

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
        $id = $request->getParams("id");
        $oldPassword = $request->getBody("oldPassword");
        $newPassword = $request->getBody("newPassword");
        $confirmNewPassword = $request->getBody("confirmNewPassword");

        /**
         * $user = UserModel::findOneById($id)
         * if (!$user) {
         *  return 404 "User not found"
         * } 
         * 
         * $userModel
         *  ->setName() ...
         * 
         * $userModel->save()
         */

        $response->json([

        ]);
    }

    public function remove(Request $request, Response $response) {
        $response
            ->setStatus(405)
            ->json([
                "status" => false,
                "message" => "Method not allowed"
            ]);
    }

    public function checkEmailExists(Request $request, Response $response) {
        $email = $request->getBody("email");
    }

}
