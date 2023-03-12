<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

class LevelController {
    public function create(Request $request, Response $response): void {
        $title = $request->getBody("title");
        $description = $request->getBody("description");
        $price = $request->getBody("price");

        var_dump($request->getBody());die;
    }
}
