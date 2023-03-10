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
    public function create(Request $request, Response $response): void {
        $file = $request->getFiles("image");
        if (!$file) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Faltan parametros"
                ]);
            return;
        }

        $name = "profilePicture-" . time();
        $size = $file->getSize();
        $contentType = $file->getType();
        $data = $file->getContent();

        $image = new ImageModel();
        $image
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data);

        $result = $image->save();

        // Store the image id in the session
        $request = $request->getSession();
        $request->set("image_id", $image->getId());

        $response->json([
            "status" => $result,
            "id" => $image->getId(),
            "message" => "Image was successfully created"
        ]);
    }

    public function update(Request $request, Response $response): void {
        // Para actualizar la imagen debe ser tuya
        
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

        $file = $request->getFiles("image");
        if (!$file) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        // No creo que sea necesaria actualizar el nombre pero si lo hacemos
        // tecnicamente no afectaria ya que todo se basa en el id
        $name = "profilePicture-" . time();
        $size = $file->getSize();
        $contentType = $file->getType();
        $data = $file->getContent();

        $image = ImageModel::findOneById($id);
        $image
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data);

        $image->update();

        $response
            ->json([]);

    }

    public function getOne(Request $request, Response $response): void {
        // No deberia ver las imagenes de las lecciones porque solo los que compraron
        // el curso pueden verlas
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

        $image = ImageModel::findOneById($id);
        if (!$image) {
            $response
                ->setStatus(404)
                ->json([
                    "status" => false,
                    "message" => "Image not found"
                ]);
            return;
        }

        $response->setHeader("X-Image-Id", $image->getId());
        $response->setHeader("Content-Length", $image->getSize());
        $response->setContentType($image->getContentType());
        $response->setHeader("Content-Disposition", 'inline; filename="' . $image->getName() . '"');
        $dt = new DateTime($image->getModifiedAt());
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($image->getData());
    }
}
