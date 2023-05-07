<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Course;
use Cursotopia\Entities\CourseCategory;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseCategoryRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\EnrollmentRepository;
use Cursotopia\Repositories\LessonRepository;
use Cursotopia\Repositories\LevelRepository;
use Cursotopia\Repositories\ReviewRepository;

class CourseController {
    public function webCreate(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
    
        $categories = CategoryModel::findAllWithUser($id);
    
        $response->render("course-creation", [ "categories" => $categories ]);
    }

    public function details(Request $request, Response $response): void {
        $id = $request->getQuery("id");
        if (!Validate::uint($id)) {
            $response->setStatus(404)->render("404");
            return;
        }

        // verificar si compre o no el curso

        // TODO: Hay que validar cualquier id
        
        $courseRepository = new CourseRepository();
        $course = $courseRepository->courseDetailsfindOneById($id);
        
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAllByCourse($id);
        
        $levelRepository = new LevelRepository();
        $levels = $levelRepository->findAllByCourse($id);
        foreach ($levels as &$level) {
            $level["lessons"] = json_decode($level["lessons"], true);
        }
        $session = $request->getSession();
        $userId = $session->get("id");
        
        $lessonRepository = new LessonRepository();
        $lesson = $lessonRepository->firstLessonPending($id, $userId ?? -1);
        if (!$lesson) {
            $lesson = $lessonRepository->firstLessonComplete($id, $userId ?? -1);
        }

        $enrollmentRepository = new EnrollmentRepository();
        $enrollment = $enrollmentRepository->findOneByCourseAndStudent($id, $userId ?? -1);

        $reviewRepository = new ReviewRepository();
        $reviews = $reviewRepository->findByCourse($id,1,10);

        if (!$course || !$categories || !$levels) {
            $response->setStatus(404)->render("404");
            return;
        }

        $response->render("course-details", [ 
            "course" => $course, 
            "categories" => $categories,
            "levels" => $levels,
            "reviews" => $reviews,
            "enrollment" => $enrollment,
            "lesson" => $lesson
        ]);
    }

    public function webUpdate(Request $request, Response $response): void {
        $id = $request->getQuery("id");
        if (!$id) {
            $response->setStatus(404)->render("404");
            return;
        }

        $course = CourseModel::findById2($id);
        
        //var_dump($course);die;

        
        $categories = CategoryModel::findAll();
        $response->render("course-edition", [ 
            "course" => $course,
            "categories" => $categories 
        ]);
    }

    public function visor(Request $request, Response $response): void {
        $session = $request->getSession();
        $userId = $session->get("id");
        // La ultima lección que viste
        // El enrollment es necesario
        // No puedes verlo si no has pagado
                
        $courseId = $request->getQuery("course");
        $lessonId = $request->getQuery("lesson");

        $course = CourseModel::findById($courseId);
        if ($course)
        $course = $course->toObject();

        $enrollmentRepository = new EnrollmentRepository();
        $enrollment = $enrollmentRepository->findOneByCourseAndStudent($courseId, $userId);

        $lessonRepository = new LessonRepository();
        $lesson = $lessonRepository->courseVisorFindById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->render("404");
            return;
        }

        $levelRepository = new LevelRepository();
        
        $levels = $levelRepository->findAllUserComplete($courseId, $userId);
        $found = false;
        foreach ($levels as &$level) {
            if ($lesson["levelId"] === $level["id"]) {
                $found = true;
            }
            $level["lessons"] = json_decode($level["lessons"], true);
        }
    
        if (!$found) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        if (is_null($lesson)) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        $response->render("course-visor", [ 
            "course" => $course,
            "levels" => $levels,
            "lesson" => $lesson,
            "enrollment" => $enrollment
        ]);
    }

    public function admin(Request $request, Response $response): void {
        $courses = CourseModel::findByNotApproved();
        $response->render("admin-courses", [ "courses" => $courses ]);
    }

    public function courseDetails(Request $request, Response $response): void {
        $courseId = $request->getQuery("course_id");
    
        $page = $_GET["page"] ?? 1;
    
        $perPageElement = 12;
        $start = ($page - 1) * $perPageElement;
    
        $limit = $perPageElement;
        $offset = $start;
    
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        $total = CourseModel::enrollmentsReportTotal($courseId, null, null);
    
        $totalPages = ceil($total / $perPageElement);
        $totalButtons = $totalPages > 5 ? 5 : $totalPages;
    
        $enrollments = CourseModel::enrollmentsReport($courseId, null, null, $limit, $offset);
    
        $response->render('instructor-course-details', [ 
            "course" => $course->toObject(), 
            "enrollments" => $enrollments,
            "totalPages" => $totalPages,
            "totalButtons" => $totalButtons,
            "page" => $page
        ]);
    }

    public function search(Request $request, Response $response): void {
        $title = $request->getQuery("title", null);
        $startDate = $request->getQuery("start_date", null);
        $endDate = $request->getQuery("end_date", null);
        $instructorId = $request->getQuery("instructor", null);
        $categoryId = $request->getQuery("category", null);
        $page = $request->getQuery("page", 1);

        $perPageElement = 12;
        $start = ($page - 1) * $perPageElement;

        $limit = $perPageElement;
        $offset = $start;

        if (!Validate::uint($instructorId)) {
            $instructorId = null;
        }

        if (!Validate::uint($categoryId)) {
            $categoryId = null;
        }

        if (!Validate::date($startDate)) {
            $startDate = null;
        }

        if (!Validate::date($endDate)) {
            $endDate = null;
        }

        $total = CourseModel::findSearchTotal(
            $title, 
            $instructorId, 
            $categoryId, 
            $startDate, 
            $endDate,
        );

        $totalPages = ceil($total / $perPageElement);

        $courses = CourseModel::findSearch(
            $title, 
            $instructorId, 
            $categoryId, 
            $startDate, 
            $endDate,
            $limit, 
            $offset
        );

        $categories = CategoryModel::findAll();

        $response->render("search", [
            "courses" => $courses,
            "categories" => $categories,
            "title" => $title ?? "",
            "startDate" => $startDate ?? "",
            "endDate" => $endDate ?? "",
            "instructorId" => $instructorId,
            "page" => $page,
            "totalPages" => $totalPages,
            "totalButtons" => $totalPages > 5 ? 5 : $totalPages 
        ]);
    }

    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
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
        $courseId = $courseRepository->lastInsertId2();

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
        $id = $request->getParams("id");
        [
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "categories" => $categories
        ] = $request->getBody();

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

        DB::beginTransaction();
        $course = CourseModel::findById($id);
        $course
            ->setTitle($title)
            ->setDescription($description)
            ->setPrice($price);
        $result = $course->save();

        $courseCategoryRepository = new CourseCategoryRepository();
        $courseCategoryRepository->deleteByCourse($id);
        foreach ($categories as $category) {
            $courseCategory = new CourseCategory();
            $courseCategory
                ->setCourseId($id)
                ->setCategoryId($category);

            $rowsAffected = $courseCategoryRepository->create($courseCategory);
        }
        DB::commit();

        $response->json([
            "status" => true,
            "id" => $id,
            "message" => $rowsAffected
        ]);

    }

    public function delete(Request $request, Response $response): void {
        $id = $request->getParams("id");
        
        $courseRepository = new CourseRepository();
        $result = $courseRepository->delete($id);

        $response->json([]);
    }

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

    public function approve(Request $request, Response $response): void {
        $courseId = $request->getParams("id");
        $session = $request->getSession();
        [
            "approve" => $approve
        ] = $request->getBody();

        $adminId = $session->get("id");
        $role = $session->get("role");

        //Validar que el curso exista

        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrad0"
            ]);
            return;
        }

        //Validar que el usuario sea administrador

        if ($role!=1) {
            $response->json([
                "status" => false,
                "message" => "Solo los administradores pueden aprobar cursos"
            ]);
            return;
        }

        $result = CourseModel::approve($courseId, $adminId, $approve);

        if(!$result){
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "No se pudo aprobar el curso"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => $result
        ]);
    }

    public function deny(Request $request, Response $response): void {
        $courseId = $request->getParams("id");
        $session = $request->getSession();
        $adminId = $session->get("id");
        $role = $session->get("role");
    
        //Validar que el curso exista
    
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }
    
        //Validar que el usuario sea administrador
    
        if ($role!=1) {
            $response->json([
                "status" => false,
                "message" => "Solo los administradores pueden aprobar cursos"
            ]);
            return;
        }
    
        $result = CourseModel::deny($courseId);
    
        if(!$result){
            $response->json([
                "status" => false,
                "message" => "No se pudo denegar el curso"
            ]);
            return;
        }
    
        $response->json([
            "status" => true,
            "message" => $result
        ]);
    }

    public function findByNotApproved(Request $request, Response $response): void {
        
        $result = CourseModel::findByNotApproved();
    
        if(!$result){
            $response->json([
                "status" => false,
                "message" => "No se pudo obtener los cursos"
            ]);
            return;
        }
    
        $response->json([
            "status" => true,
            "courses" => $result
        ]);
    }

}



