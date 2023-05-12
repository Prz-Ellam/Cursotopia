<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\LevelModel;
use Exception;

class LevelController {
    public function getOne(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        if ($id === 0) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador invalido"
            ]);
            return;
        }

        $level = LevelModel::findObjById($id);
        if (!$level) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Nível no encontrado"
            ]);
            return;
        }

        // TODO: Status
        $response->json($level);
    }

    public function create(Request $request, Response $response): void {
        try {
            [
                "title" => $title,
                "description" => $description,
                "free" => $free,
                "courseId" => $courseId
            ] = $request->getBody();

            $requestedCourse = CourseModel::findById($courseId);
            if (!$requestedCourse) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "El curso no existe"
                ]);
                return;
            }
            
            $level = new LevelModel([
                "title" => $title,
                "description" => $description,
                "free" => $free,
                "courseId" => $courseId
            ]);
            
            $isCreated = $level->save();
            if (!$isCreated) {
                $response->setStatus(400)->json([
                    "status" => true,
                    "message" => "El nível no se pudo crear"
                ]);
                return;
            }
            
            $response->setStatus(201)->json([
                "status" => true,
                "message" => "El nível fue creado éxitosamente",
                "id" => $level->getId()
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
        try {
            $userId = $request->getSession()->get("id");
            $id = intval($request->getParams("id"));
            [
                "title" => $title,
                "description" => $description,
                "free" => $free
            ] = $request->getBody();
            
            $level = LevelModel::findById($id);

            if (!$level) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Nível no encontrado"
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

            $level
                ->setTitle($title)
                ->setDescription($description)
                ->setFree($free);

            $isUpdated = $level->save();
            // if (!$isUpdated) {
            //     $response->setStatus(400)->json([
            //         "status" => true,
            //         "message" => "El nível no se pudo actualizar"
            //     ]);
            //     return;
            // }

            $response->json([
                "status" => true,
                "message" => "El nível se actualizó éxitosamente"
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }

    public function delete(Request $request, Response $response): void {
        try {
            $userId = $request->getSession()->get("id");
            $id = intval($request->getParams("id"));

            $level = LevelModel::findById($id);

            if (!$level) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Nível no encontrado"
                ]);
                return;
            }

            $level
                ->setActive(false);

            $isDeleted = $level->save();
            if (!$isDeleted) {
                $response->setStatus(400)->json([
                    "status" => true,
                    "message" => "El nível no se pudo eliminar"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "El nível fue eliminado éxitosamente"
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }
}
