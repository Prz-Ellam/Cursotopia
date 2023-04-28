<?php

namespace Cursotopia\Controllers;

use Bloom\Hashing\Crypto;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;

class AuthController {
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
                "message" => "Tu cuenta esta bloqueada"
            ]);
            return;
        }

        $session->set("id", $user->getId());
        $session->set("role", $user->getUserRole());
        $session->set("profilePicture", $user->getProfilePicture());

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
        $response->redirect("/");
    }
}
