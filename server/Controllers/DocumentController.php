<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\DocumentModel;
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
        
    }

    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "ID is not valid"
            ]);
            return;
        }

        $document = DocumentModel::findById($id);
        if (!$document) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Documento no encontrado"
            ]);
            return;
        }

        $data = file_get_contents($document["address"]);
        
        $response->setContentType("application/pdf");
        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", 'inline; filename="' . $document["name"] . '"');
        $dt = new DateTime($document["createdAt"]);
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($data);
    }
}
