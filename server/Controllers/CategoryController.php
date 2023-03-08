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
    public function store(Request $request, Response $response): void {
        $title = $request->getBody("title");
        $description = $request->getBody("description");
    }
}
