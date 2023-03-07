<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;

class AuthController {
    public function login(Request $request, Response $response): void {
        $email = $request->getBody("email");
        $password = $request->getBody("password");

        $userModel = new UserModel();
        $userModel->setEmail($email);
        $result = $userModel->login();


        $session = $request->getSession();
        if ($password == $result[0]["password"]) {
            $session->set("id", $result[0]["id"]);
            //$session->set("role", $result[""]);
            
        }
        $response->json([]);
    }
}
