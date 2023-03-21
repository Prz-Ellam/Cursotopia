<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Document;
use Cursotopia\Repositories\DocumentRepository;
use DateTime;

class DocumentController {
    public function create(Request $request, Response $response): void {
        $file = $request->getFiles("pdf");
        if (!$file) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Faltan parametros"
                ]);
            return;
        }

        $name = "document-" . time();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $address = $_SERVER["DOCUMENT_ROOT"] . "/uploads/$name.$ext";

        move_uploaded_file($file->getTmpName(), $address);

        $documentRepository = new DocumentRepository();
        $document = new Document();
        $document
            ->setName($name)
            ->setContentType($contentType)
            ->setAddress($address);

        $rowsAffected = $documentRepository->create($document);
        $pdfId = DB::lastInsertId();
        
        $response->json([
            "status" => true,
            "id" => $pdfId,
            "message" => $rowsAffected
        ]);
    }

    public function update(Request $request, Response $response): void {
        
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

        $documentRepository = new DocumentRepository();
        $document = $documentRepository->findOne($id);

        $data = file_get_contents($document["address"]);
        
        $response->setContentType("application/pdf");
        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", 'inline; filename="' . $document["name"] . '"');
        $dt = new DateTime($document["createdAt"]);
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($data);
    }
}
