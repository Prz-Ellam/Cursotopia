<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Cursotopia\Models\UserModel;

class UserController {

    public function index(Request $request, Response $response): void {

    }

    /**
     * Crea y guarda un nuevo usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function store(Request $request, Response $response): void {
        // La foto de perfil debe existir y no debe tenerla alguien más en la BD
        // El id de la foto de perfil debe almacenarse en la sessión
        // El rol debe existir
        
        $profilePicture = $request->getBody("profilePicture");
        $name = $request->getBody("name");
        $lastName = $request->getBody("lastName");
        $userRole = $request->getBody("userRole");
        $gender = $request->getBody("gender");
        $birthDate = $request->getBody("birthDate");
        $email = $request->getBody("email");
        $password = $request->getBody("password");
        $confirmPassword = $request->getBody("confirmPassword");

        $userModel = new UserModel();
        $userModel
            ->setProfilePicture($profilePicture)
            ->setName($name)
            ->setLastName($lastName)
            ->setUserRole($userRole)
            ->setGender($gender)
            ->setBirthDate($birthDate)
            ->setEmail($email)
            ->setPassword($password)
            ->setConfirmPassword($confirmPassword);

        $userValidator = new Validator($userModel);
        if (!$userValidator->validate()) {
            $response->json([
                "status" => false,
                "message" => $userValidator->getFeedback()
            ]);
            return;
        }

        $status = $userModel->save();

        $response->json([
            "status" => $status,
            "id" => $userModel->getId(),
            "message" => "The user was sucessfully created"
        ]);
    }

    public function update(Request $request, Response $response): void {

    }

    public function updatePassword(Request $request, Response $response): void {

    }

    public function remove(Request $request, Response $response) {
        $response
            ->setStatus(405)
            ->json([
                "status" => false,
                "message" => "Method not allowed"
            ]);
    }

}
