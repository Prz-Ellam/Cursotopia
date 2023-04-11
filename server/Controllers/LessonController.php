<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Lesson;
use Cursotopia\Models\LevelModel;
use Cursotopia\Repositories\LessonRepository;

class LessonController {
    public function create(Request $request, Response $response): void {
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
            "linkId" => $linkId
        ] = $request->getBody();

        
        $requestedLevel = LevelModel::findById($levelId);
        if (!$requestedLevel) {
            $response->json([
                "status" => false,
                "message" => "El nível no existe"
            ]);
            return;
        }
        

        $lessonRepository = new LessonRepository();
        $lesson = new Lesson();
        $lesson
            ->setTitle($title)
            ->setDescription($description)
            ->setLevelId($levelId)
            ->setVideoId($videoId)
            ->setImageId($imageId)
            ->setDocumentId($documentId)
            ->setLinkId($linkId);

        $rowsAffected = $lessonRepository->create($lesson);
        $response->json($rowsAffected);
    }

    public function update(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
    }

    public function delete(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
    }
}
