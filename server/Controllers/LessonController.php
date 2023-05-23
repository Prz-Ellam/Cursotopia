<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Models\LinkModel;
use Exception;

class LessonController {
    /**
     * Obtiene una lección
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getOne(Request $request, Response $response): void {
        $lessonId = intval($request->getParams("id"));
        $userId = intval($request->getSession()->get("id"));
        if (!Validate::uint($lessonId)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
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

        if (!$lesson->getActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        if ($lesson->getInstructorId() !== $userId) {
            $response->setStatus(403)->json([
                "status" => false,
                "message" => "No autorizado"
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

    /**
     * Actualiza una lección
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        $lessonId = intval($request->getParams("id"));
        [
            "title" => $title,
            "description" => $description,
            "link" => $link
        ] = $request->getBody();

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        // Vacio
        if ($link["name"] === "" || $link["url"] === "") {
            $linkId = $lesson->getLinkId();

            $link = LinkModel::findById($linkId);
            if ($link) {
                $link
                    ->setActive(false);

                $link->save();

                $lesson->setLinkId(null);
                $lesson->save();
            }
        }

        // Ambos llenos
        else if ($link["name"] !== "" && $link["url"] !== "") {
            $linkModel = new LinkModel([
                "name" => $link["name"],
                "address" => $link["url"]
            ]);
            $isCreated = $linkModel->save();

            if ($isCreated) {
                $lesson->setLinkId($linkModel->getId());
                $lesson->save();
            }
        }

        if (!$lesson->getImageId() && !$lesson->getVideoId() 
            && !$lesson->getDocumentId() && !$lesson->getLinkId()) {
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

        if ($lesson->getCourseIsComplete()) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Este curso fue completado y no puede ser editado"
            ]);
            return;
        }

        $lesson
            ->setTitle($title)
            ->setDescription($description);
        
        $isUpdated = $lesson->save();

        $response->json([
            "status" => true,
            "message" => "La lección se actualizó éxitosamente"
        ]);
    }

    public function delete(Request $request, Response $response): void {
        try {
            $userId = intval($request->getSession()->get("id"));
            $lessonId = intval($request->getParams("id"));

            $lesson = LessonModel::findById($lessonId);
            if (!$lesson) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Lección no encontrada"
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

            if ($lesson->getCourseIsComplete()) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "Este curso fue completado y no puede ser eliminado"
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
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }

    // TODO:
    public function complete(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        $lessonId = intval($request->getParams("id")) ?? -1;

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $level = LevelModel::findById($lesson->getLevelId());
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Nível de la lección no encontrado"
            ]);
            return;
        }

        $enrollment = EnrollmentModel::findOneByCourseAndStudent($level->getCourseId(), $userId);
        if (!$enrollment) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El usuario no esta suscrito al curso"
            ]);
            return;
        }

        if (!$enrollment->getIsPaid() && !$level->isFree()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El usuario no ha pagado por esta lección"
            ]);
            return;
        }

        EnrollmentModel::completeLesson($userId, $lessonId);
        
        $response->json([
            "status" => true,
            "message" => "La lección fue completada"
        ]);
    }

    // TODO:
    public function visit(Request $request, Response $response): void {
        $id = intval($request->getSession()->get("id"));
        $lessonId = intval($request->getParams("id")) ?? -1;

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $result = EnrollmentModel::visitLesson($id, $lessonId);

        $response->json([
            "status" => true,
            "message" => "Le lección fue vista"
        ]);
    }
}
