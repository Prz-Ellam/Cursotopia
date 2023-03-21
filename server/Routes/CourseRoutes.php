<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CourseController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\EnrollmentRepository;
use Cursotopia\Repositories\LessonRepository;
use Cursotopia\Repositories\LevelRepository;
use Cursotopia\Repositories\ReviewRepository;

$app->get('/course-creation', function($request, $response) {
    $categories = CategoryModel::findAll();

    $response->render('course-creation', [ "categories" => $categories ]);
}, [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/course-details', function($request, $response) {
    $id = $request->getQuery("id");
    if (!$id || !((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    // verificar si compre o no el curso

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
    $lesson = $lessonRepository->findFirstNotViewed($id, $userId);

    $enrollmentRepository = new EnrollmentRepository();
    $enrollment = $enrollmentRepository->findOneByCourseIdAndStudentId($id, $userId);

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
    $courseId = $request->getQuery("course");
    $lessonId = $request->getQuery("lesson");

    $levelRepository = new LevelRepository();
    $levels = $levelRepository->findAllByCourse($courseId);
    foreach ($levels as &$level) {
        $level["lessons"] = json_decode($level["lessons"], true);
    }

    $lessonRepository = new LessonRepository();
    $lesson = $lessonRepository->findOneById($lessonId);

    $response->render("course-visor", [ 
        "course" => $courseId,
        "levels" => $levels,
        "lesson" => $lesson
    ]);
}, [ [ HasNotAuthMiddleware::class ] ]);



$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);
$app->get('/api/v1/courses/:id', [ CourseController::class, 'getOne' ]);
//$app->get('/api/v1/users/:id/courses', [ CourseController::class, 'getAllByUser' ]);

$app->post('/api/v1/courses', [ CourseController::class, 'create' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->put('/api/v1/courses/:id', [ CourseController::class, 'update' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->delete('/api/v1/courses/:id', [ CourseController::class, 'remove' ], [ [ ApiInstructorMiddleware::class ] ]);
