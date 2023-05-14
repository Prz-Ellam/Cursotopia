<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\CourseCategory;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\DocumentModel;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\ImageModel;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LevelModel;
use Cursotopia\Models\ReviewModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Models\VideoModel;
use Cursotopia\Repositories\CourseCategoryRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\LessonRepository;
use Cursotopia\Repositories\LevelRepository;

class CourseController {
    public function webCreate(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
    
        $categories = CategoryModel::findAllWithUser($userId);
    
        $response->render("course-creation", [ 
            "categories" => $categories 
        ]);
    }

    public function details(Request $request, Response $response): void {
        $id = $request->getQuery("id");
        if (!Validate::uint($id)) {
            $response->setStatus(404)->render("404");
            return;
        }

        $session = $request->getSession();
        $userId = $session->get("id");
        $role = $session->get("role");

        // verificar si compre o no el curso

        // TODO: Hay que validar cualquier id
        
        $courseRepository = new CourseRepository();
        $course = $courseRepository->courseDetailsfindOneById($id);
        if (!$course) {
            $response->setStatus(404)->render("404");
            return;
        }

        if (!$course["approved"] && $role != 1) {
            $response->setStatus(404)->render("404");
            return;
        }
        
        $categories = CategoryModel::findAllByCourse($id);
        
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

        $enrollment = EnrollmentModel::findOneByCourseIdAndStudentId($id, $userId);
        if ((!$course["active"] && !$enrollment) && ($course["instructorId"] != $userId)) {
            $response->setStatus(404)->render("404");
            return;
        }

        if ($enrollment) {
            $enrollment = $enrollment->toArray();
        }

        $pageNum = 1;
        $pageSize = 5;

        $reviews = ReviewModel::findByCourse($id, $pageNum, $pageSize);
        $reviewsTotal = ReviewModel::findTotalByCourse($id);

        $totalPages = ceil($reviewsTotal / $pageSize);

        if (!$course || !$categories || !$levels) {
            $response->setStatus(404)->render("404");
            return;
        }

        $response->render("course-details", [ 
            "course" => $course, 
            "categories" => $categories,
            "levels" => $levels,
            "reviews" => $reviews,
            "reviewsTotalPages" => $totalPages,
            "enrollment" => $enrollment,
            "lesson" => $lesson
        ]);
    }

    public function webUpdate(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $courseId = $request->getQuery("id");
        if (!Validate::uint($courseId)) {
            $response->setStatus(404)->render("404");
            return;
        }

        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->render("404");
            return;
        }

        // Verificar que sea el creador del curso
        if ($userId != $course->getInstructorId()) {
            $response->setStatus(404)->render("404");
            return;
        }

        // Verificar que sea un curso activo
        if (!$course->isActive()) {
            $response->setStatus(404)->render("404");
            return;
        }
            
        $categories = CategoryModel::findAll();
        $response->render("course-edition", [ 
            "course" => $course->toArray(),
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

        $course = CourseModel::findObjById($courseId);

        $enrollment = EnrollmentModel::findOneByCourseIdAndStudentId($courseId, $userId);

        $lessonRepository = new LessonRepository();
        $lesson = $lessonRepository->courseVisorFindById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->render("404");
            return;
        }

        $video = VideoModel::findById($lesson["videoId"]);
        if (!$video || !$video->getActive()) {
            $lesson["videoId"] = null;
        }

        $image = ImageModel::findById($lesson["imageId"]);
        if (!$image || !$image->getActive()) {
            $lesson["imageId"] = null;
        }

        $document = DocumentModel::findById($lesson["documentId"]);
        if (!$document || !$document->isActive()) {
            $lesson["documentId"] = null;
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
            "enrollment" => $enrollment->toArray()
        ]);
    }

    public function admin(Request $request, Response $response): void {
        $courses = CourseModel::findByNotApproved();
        $response->render("admin-courses", [ 
            "courses" => $courses 
        ]);
    }

    public function courseDetails(Request $request, Response $response): void {
        $courseId = $request->getQuery("course_id");
    
        $page = $request->getQuery("page", 1);
    
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
    
        $response->render("instructor-course-details", [ 
            "course" => $course->toArray(), 
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

        if (!Validate::maxlength($title, 50)) {
            $title = null;
        }

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

        $user = UserModel::findById($instructorId);
        if ($user) {
            $userName = $user->getName() . " " . $user->getLastName();
        }
        else {
            $userName = "";
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
            "categoryId" => $categoryId,
            "title" => $title ?? "",
            "startDate" => $startDate ?? "",
            "endDate" => $endDate ?? "",
            "instructorId" => $instructorId,
            "instructorName" => $userName,
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
                "message" => "Identificador no valido"
            ]);
            return;
        }

        $courseRepository = new CourseRepository();
        $course = $courseRepository->courseDetailsfindOneById($id);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

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

        $instructorId =  $request->getSession()->get("id");

        // TODO
        // 1. Validar que las categorias que se solicitaron existan
        // 2. Las categorías que no han sido aprobadas tambien
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

        $isCreated = $course->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => true,
                "message" => "El curso no se pudo crear"
            ]);
            return;
        }

        foreach ($categories as $category) {
            $courseCategory = new CourseCategory();
            $courseCategory
                ->setCourseId($course->getId())
                ->setCategoryId($category);

            $courseCategoryRepository = new CourseCategoryRepository();
            $rowsAffected = $courseCategoryRepository->create($courseCategory);
        }
        DB::commit();

        $response->json([
            "status" => true,
            "id" => $course->getId(),
            "imageId" => $imageId,
            "message" => $rowsAffected
        ]);
    }

    public function update(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $id = intval($request->getParams("id"));
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

        //DB::beginTransaction();
        $course = CourseModel::findById($id);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        if ($userId != $course->getInstructorId()) {
            $response->setStatus(403)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }

        $course
            ->setTitle($title)
            ->setDescription($description)
            ->setPrice($price);
        $isUpdated = $course->save();
        /*
        if (!$isUpdated) {
            $response->setStatus(400)->json([
                "status" => true,
                "message" => "El curso no se pudo actualizar"
            ]);
            return;
        }
        */

        $courseCategoryRepository = new CourseCategoryRepository();
        $courseCategoryRepository->deleteByCourse($id);
        foreach ($categories as $category) {
            $courseCategory = new CourseCategory();
            $courseCategory
                ->setCourseId($id)
                ->setCategoryId($category);

            $rowsAffected = $courseCategoryRepository->create($courseCategory);
        }
        //DB::commit();

        $response->json([
            "status" => true,
            "id" => $id,
            "message" => $rowsAffected
        ]);

    }

    public function delete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $id = intval($request->getParams("id"));
        
        $course = CourseModel::findById($id);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        if ($userId != $course->getInstructorId()) {
            $response->setStatus(403)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }

        $course
            ->setActive(false);
        
        $isDeleted = $course->save();
        if (!$isDeleted) {
            $response->setStatus(400)->json([
                "status" => true,
                "message" => "El curso no se pudo eliminar"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "El curso se eliminó éxitosamente"
        ]);
    }

    public function confirm(Request $request, Response $response): void {
        $courseId = intval($request->getParams("id"));

        if ($courseId === 0) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

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

        $result = $course
            ->setIsComplete(true)
            ->save();

        if (!$result) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El curso no pudo ser aprobado"
            ]);
        }

        $response->json([
            "status" => true,
            "message" => "El curso fue completado éxitosamente"
        ]);
    }

    public function approve(Request $request, Response $response): void {
        $courseId = $request->getParams("id");
        $adminId = $request->getSession()->get("id");
        [
            "approve" => $approve
        ] = $request->getBody();

        //Validar que el curso exista
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        $course
            ->setApproved(true)
            ->setApprovedBy($adminId)
            ->setApprovedAt(date('Y-m-d H:i:s'));

        $result = $course->save();

        if (!$result) {
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
    
        //Validar que el curso exista
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }
    
        $course
            ->setApproved(false)
            ->setApprovedBy($adminId)
            ->setApprovedAt(date('Y-m-d H:i:s'));

        $result = $course->save();
    
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo denegar el curso"
            ]);
            return;
        }
    
        $response->json([
            "status" => true,
            "message" => "El curso fue rechazado"
        ]);
    }

    public function findByNotApproved(Request $request, Response $response): void {
        
        $result = CourseModel::findByNotApproved();
    
        if (!$result) {
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
