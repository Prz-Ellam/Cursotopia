<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\LevelModel;
use Exception;

class LevelController {
    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");

        $level = LevelModel::findById($id);
        $response->json($level->toObject());
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
            $level->save();
            
            $response->setStatus(201)->json([
                "status" => true,
                "message" => "El nível fue agregado éxitosamente",
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
            $id = intval($request->getParams("id"));
            [
                "title" => $title,
                "description" => $description,
                "free" => $free
            ] = $request->getBody();
            
            $level = LevelModel::findById($id);
            $level
                ->setTitle($title)
                ->setDescription($description)
                ->setFree($free);

            $isCreated = $level->save();
            if (!$isCreated) {
                $response->setStatus(400)->json([
                    "status" => true,
                    "message" => "El nível no se pudo actualizar"
                ]);
                return;
            }

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
            $id = intval($request->getParams("id"));

            $level = LevelModel::findById($id);
            $level
                ->setActive(false);

            $status = $level->save();

            $response->json([
                "status" => true,
                "message" => $status
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
