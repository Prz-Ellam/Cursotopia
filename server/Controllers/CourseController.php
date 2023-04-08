<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Course;
use Cursotopia\Entities\CourseCategory;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseCategoryRepository;
use Cursotopia\Repositories\CourseRepository;

class CourseController {
    public function create(Request $request, Response $response): void {
        // Para crear un curso debe estar autenticado y debe ser rol instructor
        $session = $request->getSession();

        [
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "categories" => $categories,
            "imageId" => $imageId
        ] = $request->getBody();

        $instructorId = $session->get("id");

        // TODO
        // 1. Validar que las categorias que se solicitaron existan
        // 2. Validar que la imagen exista y que nadie mas la este usando
        // 3. Validar que el usuario este autenticado y sea un instructor (Middleware)

        DB::beginTransaction();
        $course = new Course();
        $course
            ->setTitle($title)
            ->setDescription($description)
            ->setPrice($price)
            ->setInstructorId($instructorId)
            ->setImageId($imageId);

        $courseRepository = new CourseRepository();
        $rowsAffected = $courseRepository->create($course);
        $courseId = DB::lastInsertId();

        foreach ($categories as $category) {
            $courseCategory = new CourseCategory();
            $courseCategory
                ->setCourseId($courseId)
                ->setCategoryId($category);

            $courseCategoryRepository = new CourseCategoryRepository();
            $rowsAffected = $courseCategoryRepository->create($courseCategory);
        }
        DB::commit();

        $response->json([
            "status" => true,
            "id" => $courseId,
            "message" => $rowsAffected
        ]);
    }

    public function update(Request $request, Response $response): void {

    }

    public function delete(Request $request, Response $response): void {

    }

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
}
