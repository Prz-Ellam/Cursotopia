<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\ImageModel;
use DateTime;

class ImageController {
    /**
     * Crea y guarda una nueva imagen
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function store(Request $request, Response $response): void {
        $image = $request->getFiles("image");
        if (!$image) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        $name = "image-" . time();
        $size = $image->getSize();
        $contentType = $image->getType();
        $data = $image->getContent();

        $imageModel = new ImageModel();
        $imageModel
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data);

        $result = $imageModel->save();

        $response->json([
            "status" => $result,
            "id" => $imageModel->getId(),
            "message" => "Image was successfully created"
        ]);
    }

    public function update(Request $request, Response $response): void {
        
    }
}
