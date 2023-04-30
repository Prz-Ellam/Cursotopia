<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Exception;

class LessonController {
    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        $lesson = LessonModel::findById($id);
        $response->json($lesson->toObject());
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

            $lesson = new LessonModel([
                "title" => $title,
                "description" => $description,
                "levelId" => $levelId,
                "videoId" => $videoId,
                "imageId" => $imageId,
                "documentId" => $documentId,
                "linkId" => null
            ]);
            $lesson->save();
            
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
        $id = intval($request->getParams("id"));
        [
            "title" => $title,
            "description" => $description
        ] = $request->getBody();

        $lesson = LessonModel::findById($id);
        $lesson
            ->setTitle($title)
            ->setDescription($description);
        
        $status = $lesson->save();

        $response->json([
            "status" => true,
            "message" => "La lección se actualizó éxitosamente"
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
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


