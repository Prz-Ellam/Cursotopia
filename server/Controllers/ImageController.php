<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Bloom\Validations\Validator;
use Closure;
use Cursotopia\Models\ImageModel;
use Cursotopia\Models\LessonModel;
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
        $name = Uuid::uuid4()->toString();
        $size = $file->getSize();
        $contentType = $file->getType();
        $data = $file->getContent();

        $image = ImageModel::findById($id);
        if (!$image) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Imagen no encontrada"
            ]);
            return;
        }

        $image
            ->setName($name)
            ->setSize($size)
            ->setContentType($contentType)
            ->setData($data)
            ->setActive(true);

        $imageValidator = new Validator($image);
        if (!$imageValidator->validate()) {
            $response->json([
                "status" => false,
                "message" => $imageValidator->getFeedback()
            ]);
            return;
        }

        $image->save();

        $response->json([
            "status" => true,
            "message" => "La imagen se actualizó éxitosamente"
        ]);
    }

    public function putLessonImage(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $lessonId = $request->getParams("id");

        $file = $request->getFiles("image");
        if (!$file) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
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
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Imagen no válida"
            ]);
            return;
        }

        $result = $image->save();
        if (!$result) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "No se pudo crear la imagen"
            ]);
            return;
        }

        $lesson->setImageId($image->getId());
        $lesson->save();

        $response->json([
            "status" => true,
            "message" => "Imagen cargada",
            "id" => $lesson->getImageId()
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $imageId = $request->getParams("id");

        $image = ImageModel::findById($imageId);
        if (!$image) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Imagen no encontrado"
            ]);
            return;
        }

        $image
            ->setActive(false);

        $image->save();

        $response->json([
            "status" => true,
            "message" => "La imágen fue eliminado"
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

        $image = ImageModel::findById($id);
        if (!$image) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Imagen no encontrada"
            ]);
            return;
        }

        if (!$image->getActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Imagen no encontrada"
            ]);
            return;
        }

        $expires = 60 * 60 * 24 * 7; // 1 week
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Expires: 0");
    
        $response->setHeader("X-Image-Id", $image->getId());
        $response->setHeader("Content-Length", $image->getSize());
        $response->setContentType($image->getContentType());
        $response->setHeader("Content-Disposition", 'inline; filename="' . $image->getName() . '"');
        $dt = new DateTime($image->getModifiedAt());
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($image->getData());
    }
}
