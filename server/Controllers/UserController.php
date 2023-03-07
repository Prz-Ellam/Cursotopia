<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;

class UserController {

    public function index(Request $request, Response $response) {

    }

    /**
     * Crea y guarda un nuevo usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function store(Request $request, Response $response): void {

        $profilePicture = $request->getBody("profile-picture");
        $name = $request->getBody("name");
        $lastName = $request->getBody("last-name");
        $userRole = $request->getBody("user-role");
        $gender = $request->getBody("gender");
        $birthDate = $request->getBody("birth-date");
        $email = $request->getBody("email");
        $password = $request->getBody("password");
        $confirmPassword = $request->getBody("confirm-password");

        $userModel = new UserModel();
        $userModel
            ->setProfilePicture($profilePicture)
            ->setName($name)
            ->setLastName($lastName)
            ->setUserRole($userRole)
            ->setGender($gender)
            ->setBirthDate($birthDate)
            ->setEmail($email)
            ->setPassword($password);

        $status = $userModel->save();

        $response->json([
            "status" => $status,
            "id" => $userModel->getId(),
            "message" => "The user was sucessfully created"
        ]);

    }

    public function update(Request $request, Response $response) {

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
