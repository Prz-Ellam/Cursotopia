<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\LinkModel;

class LinkController {
    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "ID is not valid"
            ]);
            return;
        }

        $link = LinkModel::findById($id);

        $response->json($link);
    }
    
    public function create(Request $request, Response $response, Closure $next): void {
        [
            "name" => $name,
            "address" => $address
        ] = $request->getBody();
        
        $link = new LinkModel([
            "name" => $name,
            "address" => $address
        ]);
        $link->save();

        $response->setStatus(201)->json([
            "status" => true,
            "message" => "En enlace se creó éxitosamente"
        ]);
    }

    public function update(Request $request, Response $response): void {

    }

    public function delete(Request $request, Response $response): void {
        
    }
}
