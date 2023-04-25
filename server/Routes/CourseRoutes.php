<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CourseController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\EnrollmentRepository;
use Cursotopia\Repositories\LessonRepository;
use Cursotopia\Repositories\LevelRepository;
use Cursotopia\Repositories\ReviewRepository;

$app->get('/course-creation', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");

    $categories = CategoryModel::findAllWithUser($id);

    $response->render('course-creation', [ "categories" => $categories ]);
}, [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/course-details', function($request, $response) {
    $id = $request->getQuery("id");
    if (!$id || !((is_int($id) || ctype_digit($id)) && intval($id) > 0)) {
        $response
            ->setStatus(404)
            ->render('404');
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
    $enrollment = $enrollmentRepository->findOneByCourseIdAndStudentId($id, $userId ?? -1);

    $reviewRepository = new ReviewRepository();
    $reviews = $reviewRepository->findAllByCourse($id);

    if (!$course || !$categories || !$levels) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $response->render('course-details', [ 
        "course" => $course, 
        "categories" => $categories,
        "levels" => $levels,
        "reviews" => $reviews,
        "enrollment" => $enrollment,
        "lesson" => $lesson
    ]);
});

$app->get('/course-edition', function($request, $response) {
    $categories = CategoryModel::findAll();
    $response->render('course-edition', [ "categories" => $categories ]);
}, [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/course-visor', function($request, $response) {
    $session = $request->getSession();
    $userId = $session->get("id");
    // La ultima lección que viste
    // El enrollment es necesario
    // No puedes verlo si no has pagado
    
    $courseId = $request->getQuery("course");
    $lessonId = $request->getQuery("lesson");

    $lessonRepository = new LessonRepository();
    $lesson = $lessonRepository->findOneById($lessonId);
    if (!$lesson) {
        $response->render("404");
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
        $response->render("404");
        return;
    }

    if (is_null($lesson)) {
        $response->render("404");
        return;
    }

    $response->render("course-visor", [ 
        "course" => $courseId,
        "levels" => $levels,
        "lesson" => $lesson
    ]);
}, [ [ HasNotAuthMiddleware::class ] ]);



//$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);
$app->get('/api/v1/courses/:id', [ CourseController::class, 'getOne' ]);
//$app->get('/api/v1/users/:id/courses', [ CourseController::class, 'getAllByUser' ]);

// Crear un curso
$app->post('/api/v1/courses', [ CourseController::class, 'create' ], [ 
    [ JsonSchemaMiddleware::class, 'CourseCreateValidator' ],
    [ ApiInstructorMiddleware::class ]
]);

// Actualizar un curso
$app->put('/api/v1/courses/:id', [ CourseController::class, 'update' ], [ 
    [ JsonSchemaMiddleware::class, 'CourseUpdateValidator' ],
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ]
]);

// Eliminar un curso
$app->delete('/api/v1/courses/:id', [ CourseController::class, 'remove' ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

$app->get('/api/v1/courses', [ CourseController::class, 'search' ]);

// Confirmar la creacion del curso
$app->put('/api/v1/courses/:id/confirm', [ CourseController::class, 'confirm' ], [
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

$app->put('/api/v1/courses/:id/approve', [ CourseController::class, 'approve' ], [
    [ ValidateIdMiddleware::class ]
]);

$app->get('/admin-courses', function($request, $response) {

    $courses = CourseModel::findByNotApproved();

    $response->render('admin-courses', [ "courses" => $courses ]);
});

$app->get('/instructor-course-details', function($request, $response) {

    $courseId = $request->getQuery("course_id");

    $course = CourseModel::findById($courseId);
    if (!$course) {
        $response->setStatus(404)->render("404");
        return;
    }

    $courseRepository = new CourseRepository();
    $enrollments = $courseRepository->courseEnrollmentsReport($courseId);

    $response->render('instructor-course-details', [ 
        "course" => $course->toObject(), 
        "enrollments" => $enrollments
    ]);
});


// TODO:
// Validar en los actualizados o eliminados que le pertenezca al usuario el recurso