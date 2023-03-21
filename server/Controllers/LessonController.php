<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Lesson;
use Cursotopia\Repositories\LessonRepository;

class LessonController {
    public function create(Request $request, Response $response): void {

        $lessonRepository = new LessonRepository();
        $lesson = new Lesson();
        $lesson
            ->setTitle($request->getBody("title"))
            ->setDescription($request->getBody("description"))
            ->setLevelId($request->getBody("levelId"))
            ->setVideoId($request->getBody("videoId"))
            ->setImageId($request->getBody("imageId"))
            ->setDocumentId($request->getBody("documentId"))
            ->setLinkId($request->getBody("linkId"))
            ;

        $rowsAffected = $lessonRepository->create($lesson);
        $response->json($rowsAffected);
    }

    public function update(Request $request, Response $response): void {
        
    }
}
