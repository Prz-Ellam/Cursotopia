<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Course;
use Cursotopia\Entities\CourseCategory;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Repositories\CourseCategoryRepository;
use Cursotopia\Repositories\CourseRepository;

class CourseController {
    public function create(Request $request, Response $response): void {
        [
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "categories" => $categories,
            "imageId" => $imageId
        ] = $request->getBody();
            
        $session = $request->getSession();
        $instructorId = $session->get("id");

        // TODO
        // 1. Validar que las categorias que se solicitaron existan
        foreach ($categories as $categoryId) {
            $category = CategoryModel::findById($categoryId);
            if (!$category) {
                $response->json([
                    "status" => false,
                    "message" => "Una categoría no existe"
                ]);
                return;
            }
        }

        // 2. Validar que la imagen exista y que nadie mas la este usando
        // 3. Validar que el usuario este autenticado y sea un instructor (Middleware)

        DB::beginTransaction();

        $course = new CourseModel([
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "instructorId" => $instructorId,
            "imageId" => $imageId
        ]);

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
        $courseId = $request->getParams("id");
        [
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "categories" => $categories
        ] = $request->getBody();
    }

    public function delete(Request $request, Response $response): void {
        $courseId = $request->getParams("id");
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

    // Confirmar creacion del curso
    public function confirm(Request $request, Response $response): void {
        $courseId = $request->getParams("id");

        $levels = LevelModel::findByCourse($courseId);
        if (count($levels) < 1) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El curso debe tener al menos un nível"
            ]);
            return;
        }

        foreach ($levels as $level) {
            $lessons = LessonModel::findByLevel($level["id"]);
            if (count($lessons) < 1) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "Cada nível debe tener al menos una lección"
                ]);
                return;
            }
            $foundVideo = false;
            foreach ($lessons as $lesson) {
                if ($lesson["videoId"]) {
                    $foundVideo = true;
                }
            }

            if (!$foundVideo) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "Cada nível debe tener al menos una lección con vídeo"
                ]);
                return;
            }
        }

        $result = CourseModel::confirm($courseId);
        /*
            
        */
        $response->json([
            "status" => true,
            "message" => $result
        ]);
    }

    // Aprobar un curso
    public function approve(Request $request, Response $response): void {
        $courseId = $request->getParams("id");
        $session = $request->getSession();
        [
            "approve" => $approve
        ] = $request->getBody();

        $adminId = $session->get("id");

        $result = CourseModel::approve($courseId, $adminId, $approve);
        $response->json([
            "status" => true,
            "message" => $result
        ]);
    }

    // Busqueda de cursos por filtros
    public function search(Request $request, Response $response): void {
        $title = $request->getQuery("title", null);
        $from = $request->getQuery("from", null);
        $to = $request->getQuery("to", null);
        $instructorId = $request->getQuery("instructor", null);
        $categoryId = $request->getQuery("category", null);
        $limit = 100;
        $offset = 0;

        if (((is_int($instructorId) || ctype_digit($instructorId)) && intval($instructorId) > 0)) {
            $instructorId = null;
        }

        $courses = CourseModel::findSearch($title, $instructorId, $categoryId, $from, $to, $limit, $offset);
        $response->json($courses);
    }
}
