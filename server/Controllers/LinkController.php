<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Entities\Link;
use Cursotopia\Helpers\Validate;
use Cursotopia\Repositories\LinkRepository;

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

        $linkRepository = new LinkRepository();
        $link = $linkRepository->findById($id);

        $response->json($link);
    }
    
    public function create(Request $request, Response $response, Closure $next): void {
        $name = $request->getBody("name");
        $address = $request->getBody("address");

        $link = new Link();
        $link
            ->setName($name)
            ->setAddress($address);

        $linkRepository = new LinkRepository();
        $rowsAffected = $linkRepository->create($link);

        $response->json($rowsAffected);
    }

    public function update(Request $request, Response $response): void {

    }

    public function delete(Request $request, Response $response): void {
        
    }
}
