<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\DocumentModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Repositories\DocumentRepository;
use DateTime;
use Ramsey\Uuid\Nonstandard\Uuid;

class DocumentController {
    public function create(Request $request, Response $response, Closure $next): void {
        $file = $request->getFiles("document");
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
                    $payloadObj["documentId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        $allowedExtensions = [ "application/pdf" ];
        if (!in_array($file->getType(), $allowedExtensions)) {
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["documentId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        if ($file->getSize() > 8 * 1024 * 1024) {
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["documentId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }
        
        $name = Uuid::uuid4()->toString();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $address = UPLOADS_DIR . "/$name.$ext";

        move_uploaded_file($file->getTmpName(), $address);

        $document = new DocumentModel([
            "name" => $name,
            "contentType" => $contentType,
            "address" => $address
        ]);
        $isCreated = $document->save();
        $documentId = $document->getId();

        /*
        $response->json([
            "status" => true,
            "id" => $pdfId,
            "message" => $rowsAffected
        ]);
        */
        $payload = $request->getBody("payload");
        if ($payload) {
            $payloadObj = json_decode($payload, true);
            if ($payloadObj) {
                $payloadObj["documentId"] = $documentId;
                $request->setBodyParam("payload", json_encode($payloadObj));
            }
        }

        $next();
    }

    public function update(Request $request, Response $response): void {
        $documentId = intval($request->getParams("id"));
        $file = $request->getFiles("document");
        if (!$file) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        $name = Uuid::uuid4()->toString();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $address = UPLOADS_DIR . "/$name.$ext";

        move_uploaded_file($file->getTmpName(), $address);

        $document = DocumentModel::findById($documentId);
        if (!$document) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        $document
            ->setName($name)
            ->setContentType($contentType)
            ->setAddress($address)
            ->setActive(true);

        $document->save();

        $response->json([
            "status" => true,
            "message" => "El documento se actualizó éxitosamente"
        ]);
    }

    public function putLessonDocument(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        $lessonId = intval($request->getParams("id"));

        $file = $request->getFiles("document");
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
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $address = UPLOADS_DIR . "/$name.$ext";

        move_uploaded_file($file->getTmpName(), $address);

        $document = new DocumentModel([
            "name" => $name,
            "contentType" => $contentType,
            "address" => $address
        ]);

        $isCreated = $document->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "No se pudo crear el documento"
            ]);
            return;
        }

        $lesson->setDocumentId($document->getId());
        $lesson->save();

        $response->json([
            "status" => true,
            "message" => "Documento cargado",
            "id" => $document->getId()
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $documentId = intval($request->getParams("id"));

        $document = DocumentModel::findById($documentId);
        if (!$document) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Documento no encontrado"
            ]);
            return;
        }

        $document
            ->setActive(false);

        $document->save();

        $response->json([
            "status" => true,
            "message" => "El documento fue eliminado"
        ]);
    }

    public function getOne(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        $documentId = intval($request->getParams("id"));
        if (!Validate::uint($documentId)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $document = DocumentModel::findById($documentId);
        if (!$document) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Documento no encontrado"
            ]);
            return;
        }

        if (!$document->isActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Documento no encontrado"
            ]);
            return;
        }

        $documentRepository = new DocumentRepository();
        $info = $documentRepository->checkAvailabityByUser($userId, $documentId);
        if (!$info) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No estas autorizado"
            ]);
            return;
        }
/*
        if ($info["free"] && $info["paid"]) {
            // Si es gratis y pagado, entonces está disponible
            $contentAvailable = true;
        } elseif ($info["free"] && !$info["paid"]) {
            // Si es gratis y no es pagado, entonces está disponible
            $contentAvailable = true;
        } elseif (!$info["free"] && $info["paid"]) {
            // Si no es gratis pero es pagado, entonces está disponible
            $contentAvailable = true;
        } else {
            // Si no es gratis y no es pagado, entonces no está disponible
            $contentAvailable = false;
        }

        if ($info["price"] == 0.0) {
            $contentAvailable = true;
        }
        
        if (!$contentAvailable) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No estás autorizado"
            ]);
            return;
        }
*/
        $data = file_get_contents($document->getAddress());
        
        $response->setContentType("application/pdf");
        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", 'inline; filename="' . $document->getName() . '"');
        $dt = new DateTime($document->getCreatedAt());
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($data);
    }
}
