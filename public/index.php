<?php

use Bloom\Application;
use Cursotopia\Controllers\AuthController;
use Cursotopia\Controllers\CourseController;
use Cursotopia\Controllers\ImageController;
use Cursotopia\Controllers\LessonController;
use Cursotopia\Controllers\LevelController;
use Cursotopia\Controllers\UserController;
use Cursotopia\Middlewares\HasAuthMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\Validators\UserLoginValidator;
use Cursotopia\Middlewares\Validators\UserSignupValidator;
use Cursotopia\Middlewares\Validators\UserUpdateValidator;

require_once "../vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$app = Application::app(dirname(__DIR__, 1));

$app->setNotFound(fn($req, $res) => $res->render('404'));

$app->get('/', fn($request, $response) => $response->redirect('/home'));
$app->get('/admin-categories', fn($request, $response) => $response->render('admin-categories'));
$app->get('/admin-courses', fn($request, $response) => $response->render('admin-courses'));
$app->get('/admin-home', fn($request, $response) => $response->render('admin-home'));
$app->get('/blocked-users', fn($request, $response) => $response->render('blocked-users'));
$app->get('/certificate', fn($request, $response) => $response->render('certificate'));
$app->get('/chat', fn($request, $response) => $response->render('chat'), [ HasNotAuthMiddleware::class ]);
$app->get('/course-creation', fn($request, $response) => $response->render('course-creation'));
$app->get('/course-details', fn($request, $response) => $response->render('course-details'));
$app->get('/course-edition', fn($request, $response) => $response->render('course-edition'));
$app->get('/course-visor', fn($request, $response) => $response->render('course-visor'));
$app->get('/home', fn($request, $response) => $response->render('home'));
$app->get('/home_student', fn($request, $response) => $response->render('home_student'));
$app->get('/home_instructor', fn($request, $response) => $response->render('home_instructor'));
$app->get('/instructor-course-details', fn($request, $response) => $response->render('instructor-course-details'));
$app->get('/instructor-profile-seen-by-others', fn($request, $response) => $response->render('instructor-profile-seen-by-others'));
$app->get('/instructor-profile', fn($request, $response) => $response->render('instructor-profile'));


$app->get('/login', fn($request, $response) => $response->render('login'), [ HasAuthMiddleware::class ]);



$app->get('/password-edition', fn($request, $response) => $response->render('password-edition'));
$app->get('/payment-method', fn($request, $response) => $response->render('payment-method'));
$app->get('/profile-edition', fn($request, $response) => $response->render('profile-edition'));
$app->get('/search', fn($request, $response) => $response->render('search'));
$app->get('/signup', fn($request, $response) => $response->render('signup'), [ HasAuthMiddleware::class ]);
$app->get('/student-profile-seen-by-others', fn($request, $response) => $response->render('student-profile-seen-by-others'));
$app->get('/student-profile', fn($request, $response) => $response->render('student-profile'));


// API

// Auth
$app->post('/api/v1/auth', [ AuthController::class, 'login' ], [ UserLoginValidator::class ]);
$app->get('/api/v1/logout', [ AuthController::class, 'logout' ]);

// Users
$app->get('/api/v1/users/:id', [ UserController::class, 'getOne' ]);

$app->post('/api/v1/users', [ UserController::class, 'create' ], [ UserSignupValidator::class ]);
$app->patch('/api/v1/users/:id', [ UserController::class, 'update' ], [ UserUpdateValidator::class ]);
$app->patch('/api/v1/users/:id/password', [ UserController::class, 'updatePassword' ]);
$app->delete('/api/v1/users/:id', [ UserController::class, 'remove' ]); // !!!



// Images
$app->get('/api/v1/images/:id', [ ImageController::class, 'getOne' ]);

$app->post('/api/v1/images', [ ImageController::class, 'create' ]);
$app->put('/api/v1/images/:id', [ ImageController::class, 'update' ]);
$app->delete('/api/v1/images/:id', [ ImageController::class, 'remove' ]);



// Courses
$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);
$app->get('/api/v1/courses/:id', [ CourseController::class, 'getOne' ]);
//$app->get('/api/v1/users/:id/courses', [ CourseController::class, 'getAllByUser' ]);
$app->post('/api/v1/courses', [ CourseController::class, 'create' ]);
$app->put('/api/v1/courses/:id', [ CourseController::class, 'update' ]);
$app->delete('/api/v1/courses/:id', [ CourseController::class, 'remove' ]);



// Levels
$app->get('/api/v1/levels/:id', [ LevelController::class, 'show' ]);
$app->post('/api/v1/levels', [ LevelController::class, 'store' ]);
$app->put('/api/v1/levels/:id', [ LevelController::class, 'update' ]);
$app->delete('/api/v1/levels/:id', [ LevelController::class, 'remove' ]);

// Lessons
$app->get('/api/v1/lessons/:id', [ LessonController::class, 'show' ]);
$app->post('/api/v1/lessons', [ LessonController::class, 'store' ]);
$app->put('/api/v1/lessons/:id', [ LessonController::class, 'update' ]);
$app->delete('/api/v1/lessons/:id', [ LessonController::class, 'remove' ]);


$app->run();
