<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Models\LinkModel;
use Exception;

class LessonController {
    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");

        $lesson = LessonModel::findById($id);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $response->json($lesson->toArray());
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

            
            $level = LevelModel::findById($levelId);
            if (!$level) {
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

        if (!$lesson->getImageId() && !$lesson->getVideoId() && !$lesson->getDocumentId()) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Falta añadir un recurso"
            ]);
            return;
        }

        if ($userId != $lesson->getInstructorId()) {
            $response->setStatus(403)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }

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

    // TODO:
    public function complete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $lessonId = $request->getParams("id") ?? -1;

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $levelId = $lesson->getLevelId();
        $level = LevelModel::findById($levelId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Nível de la lección no encontrado"
            ]);
            return;
        }

        //$enrollment = EnrollmentModel::findOneByCourseIdAndStudentId();

        // TODO: Validar que esta lección pueda ser completada si es que pago

        $result = EnrollmentModel::completeLesson($userId, $lessonId);
        $response->json([]);
    }

    // TODO:
    public function visit(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");
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
