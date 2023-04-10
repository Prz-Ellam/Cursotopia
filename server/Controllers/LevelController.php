<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Level;
use Cursotopia\Models\LevelModel;
use Cursotopia\Repositories\LevelRepository;

class LevelController {
    public function create(Request $request, Response $response): void {
        // TODO:
        // 1. Validar que el curso existe
        $courseId = $request->getParams("courseId");
        [
            "title" => $title,
            "description" => $description,
            "price" => $price
        ] = $request->getBody();

        /*
        $requestedCourse = Course::findById($courseId);
        if (!$requestedCourse) {
            $response->json([
                "status" => false,
                "message" => "El curso no existe"
            ]);
            return;
        }
        */
        
        $body = $request->getBody();

        $level = new LevelModel($body);

        $level->save();
        
        $response->json([
            "status" => true,
            "id" => $level->getId()
        ]);
    }

    public function update(Request $request, Response $response): void {
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

        $level = LevelModel::findOneById($id);
        $level
            ->setTitle($request->getBody("title"))
            ->setDescription($request->getBody("description"))
            ->setPrice($request->getBody("price"));

        $status = $level->save();

        $response->json([
            "status" => true,
            "message" => $status
        ]);
    }

    public function delete(Request $request, Response $response): void {
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

        $level = LevelModel::findOneById($id);
        $level
            ->setActive(false);

        $status = $level->save();

        $response->json([
            "status" => true,
            "message" => $status
        ]);
    }
}
