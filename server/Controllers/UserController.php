<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

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
    public function store(Request $request, Response $response) {

        $name = $request->getBody("name");
        $lastName = $request->getBody("last_name");

        $response->send($lastName);

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
