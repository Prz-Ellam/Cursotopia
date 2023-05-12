<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Closure;
use Cursotopia\Models\ImageModel;
use DateTime;
use Ramsey\Uuid\Nonstandard\Uuid;

class ImageController {
    /**
     * Crea y guarda una nueva imagen
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response, Closure $next = null): void {        
        $file = $request->getFiles("image");
        
        if (!$file) {
            /*
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            */
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["imageId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        $name = Uuid::uuid4()->toString();
        $size = $file->getSize();
        $contentType = $file->getType();
        $data = $file->getContent();

        $image = new ImageModel();
        $image
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data);

        $imageValidator = new Validator($image);
        if (!$imageValidator->validate()) {
            /*
            $response->setStatus(400)->json([
                "status" => false,
                "message" => $imageValidator->getFeedback()
            ]);
            */
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["imageId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        $result = $image->save();

        // Store the image id in the session
        //$session = $request->getSession();
        //$session->set("profilePicture_id", $image->getId());

        /*
        $response->setStatus(201)->json([
            "status" => $result,
            "id" => $image->getId(),
            "message" => "La imagen se creó éxitosamente"
        ]);
        */

        // TODO: Checar
        $payload = $request->getBody("payload");
        if ($payload) {
            $payloadObj = json_decode($payload, true);
            if ($payloadObj) {
                $payloadObj["imageId"] = $image->getId();
                $request->setBodyParam("payload", json_encode($payloadObj));
            }
        }
        
        $next();
    }

    public function update(Request $request, Response $response): void {
        // Para actualizar la imagen debe ser tuya
        $id = intval($request->getParams("id"));
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

        $image = ImageModel::findById($id);
        $image
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data);

        $imageValidator = new Validator($image);
        if (!$imageValidator->validate()) {
            $response->json([
                "status" => false,
                "message" => $imageValidator->getFeedback()
            ]);
            return;
        }

        $image->update();

        $response->json([
            "status" => true,
            "message" => "La imagen se actualizó éxitosamente"
        ]);
    }

    public function getOne(Request $request, Response $response): void {
        // No deberia ver las imagenes de las lecciones porque solo los que compraron
        // el curso pueden verlas
        $id = intval($request->getParams("id"));
        if ($id === 0) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador invalido"
            ]);
            return;
        }

        $image = ImageModel::findObjById($id);
        if (!$image) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Imagen no encontrada"
            ]);
            return;
        }
        
        $response->setHeader("X-Image-Id", $image["id"]);
        $response->setHeader("Content-Length", $image["size"]);
        $response->setContentType($image["contentType"]);
        $response->setHeader("Content-Disposition", 'inline; filename="' . $image["name"] . '"');
        $dt = new DateTime($image["modifiedAt"]);
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($image["data"]);
    }
}
