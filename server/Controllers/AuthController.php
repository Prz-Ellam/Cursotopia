<?php

namespace Cursotopia\Controllers;

use Bloom\Hashing\Crypto;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;

class AuthController {
    public function login(Request $request, Response $response): void {
        $email = $request->getBody("email");
        $password = $request->getBody("password");

        $user = new UserModel();
        $user->setEmail($email);
        $result = $user->login();


        $session = $request->getSession();
        if (Crypto::verify($result["password"], $password)) {
            $session->set("id", $result["id"]);
            $session->set("role", $result["userRole"]);
            $session->set("profilePicture", $result["profilePicture"]);
            $response->json([
                "status" => true,
                "message" => "User login successfully"
            ]);
            return;
        }
        $response->json([
            "status" => false,
            "message" => "Cannot login"
        ]);
        
    }

    public function logout(Request $request, Response $response): void {
        $session = $request->getSession();
        $session->destroy();
        $response->redirect('/');
    }
}
