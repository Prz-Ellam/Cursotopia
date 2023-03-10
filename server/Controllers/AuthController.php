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
        if (!Crypto::verify($result["password"], $password)) {
            
            if ($session->get("loginIntentsEmail") !== $email) {
                $session->set("loginIntentsEmail", $email);
                $session->set("loginIntentsCount", 1);
            }
            else {
                $count = $session->get("loginIntentsCount");
                $session->set("loginIntentsCount", $count + 1);

                if ($session->get("loginIntentsCount") >= 3) {
                    // Deshabilitar cuenta
                    //$user->setEnabled(false);
                    //$user->save();
                }
            }

            $response->json([
                "status" => false,
                "message" => "Cannot login"
            ]);
            return;
        }

        // TODO:
        // Hay que considerar también que si el usuario esta bloqueado no deberia
        // poder hacer consultas a la base de datos en ningun endpoint
        if (!$user->getEnabled()) {
            $response->json([
                "status" => false,
                "message" => "User is blocked, contact an admin to restore the account"
            ]);
            return;
        }

        $session->set("id", $result["id"]);
        $session->set("role", $result["userRole"]);
        $session->set("profilePicture", $result["profilePicture"]);

        // Eliminar la información de intentos de login
        // TODO: unset una variable que no existe
        $session->unset("loginIntentsEmail");
        $session->unset("loginIntentsCount");

        $response->json([
            "status" => true,
            "message" => "User login successfully"
        ]);    
    }

    public function logout(Request $request, Response $response): void {
        $session = $request->getSession();
        $session->destroy();
        $response->redirect('/');
    }
}
