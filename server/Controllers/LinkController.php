<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Link;
use Cursotopia\Repositories\LinkRepository;

class LinkController {
    public function create(Request $request, Response $response): void {
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

    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "ID is not valid"
                ]);
            return;
        }

        $linkRepository = new LinkRepository();
        $link = $linkRepository->findOne($id);

        $response->json($link);
    }
}
