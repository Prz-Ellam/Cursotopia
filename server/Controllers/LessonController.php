<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Models\LinkModel;
use Exception;

class LessonController {
    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");

        $lesson = LessonModel::findObjById($id);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $response->json($lesson);
    }

    public function create(Request $request, Response $response): void {
        try {
            // TODO:
            // 1. Validar que el nivel existe
            // 2. Validar que el video, imagen, documento o link existan
            [
                "title" => $title,
                "description" => $description,
                "levelId" => $levelId,
                "videoId" => $videoId,
                "imageId" => $imageId,
                "documentId" => $documentId,
                "link" => $link
                //"linkId" => $linkId
            ] = $request->getBody();

            
            $requestedLevel = LevelModel::findById($levelId);
            if (!$requestedLevel) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "El nível no existe"
                ]);
                return;
            }

            $linkId = null;
            if ($link["name"] !== "" && $link["url"] !== "") {
                $link = new LinkModel([
                    "name" => $link["name"],
                    "address" => $link["url"]
                ]);
                $isCreated = $link->save();

                if (!$isCreated) {
                    $response->setStatus(400)->json([
                        "status" => false,
                        "message" => "No se pudo crear el enlace"
                    ]);
                    return;
                }
                $linkId = $link->getId();
            }


            $lesson = new LessonModel([
                "title" => $title,
                "description" => $description,
                "levelId" => $levelId,
                "videoId" => $videoId,
                "imageId" => $imageId,
                "documentId" => $documentId,
                "linkId" => $linkId
            ]);
            $isCreated = $lesson->save();
            if (!$isCreated) {
                $response->setStatus(400)->json([
                    "status" => true,
                    "message" => "La lección no se pudo crear"
                ]);
                return;
            }
            
            $response->setStatus(201)->json([
                "status" => true,
                "message" => "La lección fue agregada éxitosamente",
                "id" => $lesson->getId()
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }

    public function update(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $id = intval($request->getParams("id"));
        [
            "title" => $title,
            "description" => $description
        ] = $request->getBody();

        $lesson = LessonModel::findById($id);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        /*
        if ($userId != $requestedLesson->getUserId()) {
            $response->setStatus(403)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }
        */

        $lesson
            ->setTitle($title)
            ->setDescription($description);
        
        $isUpdated = $lesson->save();
        // if (!$isUpdated) {
        //     $response->setStatus(400)->json([
        //         "status" => true,
        //         "message" => "La lección no se pudo actualizar"
        //     ]);
        //     return;
        // }

        $response->json([
            "status" => true,
            "message" => "La lección se actualizó éxitosamente"
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        $lesson = LessonModel::findById($id);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $lesson
            ->setActive(false);

        $isDeleted = $lesson->save();
        if (!$isDeleted) {
            $response->setStatus(400)->json([
                "status" => true,
                "message" => "La lección no se pudo eliminar"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "La lección se eliminó éxitosamente"
        ]);
    }

    public function complete(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
        $lessonId = $request->getParams("id") ?? -1;

        $requestedLesson = LessonModel::findById($lessonId);
        if (!$requestedLesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $result = EnrollmentModel::completeLesson($id, $lessonId);
        $response->json([]);
    }

    public function visit(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
        $lessonId = $request->getParams("id") ?? -1;

        $requestedLesson = LessonModel::findById($lessonId);
        if (!$requestedLesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $result = EnrollmentModel::visitLesson($id, $lessonId);
        $response->json([]);
    }
}
