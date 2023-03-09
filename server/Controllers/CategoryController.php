<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

class CategoryController {
    /**
     * Crea y guarda una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void {
        $session = $request->getSession();
        // Este es el id del usuario autenticado
        $userId = $session->get("id");

        $title = $request->getBody("title");
        $description = $request->getBody("description");
    }
}
