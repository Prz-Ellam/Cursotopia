<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

class AuthController {
    public function login(Request $request, Response $response): void {
        $email = $request->getBody("email");
        $password = $request->getBody("password");

        $session = $request->getSession();
        if ($email == "eliam@correo.com" && $password == "123") {
            $session->set("id", 1);
            $session->set("role", "student");
        }
        $response->json([
            "id" => $session->get("id")
        ]);
    }
}
