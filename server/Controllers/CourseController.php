<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseRepository;

class CourseController {

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

        $courseRepository = new CourseRepository();
        $course = $courseRepository->courseDetailsfindOneById($id);
        // $course = CourseModel::findOneById($id);
        /**
         * if (!$course) {
         *  // 404
         * }
         * 
         */
        $response->json($course);
    }

    public function store(Request $request, Response $response): void {
        // Para crear un curso debe estar autenticado y debe ser rol instructor
        
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $price = $request->getBody("price");
    }
}
