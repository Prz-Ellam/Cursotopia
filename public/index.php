<?php

use Bloom\Application;
use Cursotopia\Controllers\AuthController;
use Cursotopia\Controllers\CategoryController;
use Cursotopia\Controllers\CourseController;
use Cursotopia\Controllers\DocumentController;
use Cursotopia\Controllers\ImageController;
use Cursotopia\Controllers\LessonController;
use Cursotopia\Controllers\LevelController;
use Cursotopia\Controllers\LinkController;
use Cursotopia\Controllers\UserController;
use Cursotopia\Controllers\VideoController;
use Cursotopia\Middlewares\ApiAdminMiddleware;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\AuthMiddleware;
use Cursotopia\Middlewares\HasAuthMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\Validators\CategoryCreationValidator;
use Cursotopia\Middlewares\Validators\CategoryUpdateValidator;
use Cursotopia\Middlewares\Validators\LevelCreationValidator;
use Cursotopia\Middlewares\Validators\UserLoginValidator;
use Cursotopia\Middlewares\Validators\UserSignupValidator;
use Cursotopia\Middlewares\Validators\UserUpdatePasswordValidator;
use Cursotopia\Middlewares\Validators\UserUpdateValidator;
use Cursotopia\Middlewares\WebAdminMiddleware;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Models\UserRoleModel;

require_once "../vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$app = Application::app(dirname(__DIR__, 1));

$app->setNotFound(fn($req, $res) => $res->render('404'));

$app->get('/', fn($request, $response) => $response->redirect('/home'));
$app->get('/categories', 
    fn($request, $response) => $response->render('admin-categories'),
    [ WebAdminMiddleware::class ]);



$app->get('/admin-courses', fn($request, $response) => $response->render('admin-courses'));
$app->get('/admin-home', fn($request, $response) => $response->render('admin-home'));
$app->get('/blocked-users', fn($request, $response) => $response->render('blocked-users'));
$app->get('/certificate', fn($request, $response) => $response->render('certificate'));
$app->get('/chat', fn($request, $response) => $response->render('chat'), [ HasNotAuthMiddleware::class ]);


$app->get('/course-creation', function($request, $response) {
    $categories = CategoryModel::findAll();

    $response->render('course-creation', [ "categories" => $categories ]);
}, [ HasNotAuthMiddleware::class ]);



$app->get('/course-details', fn($request, $response) => $response->render('course-details'));


$app->get('/course-edition', function($request, $response) {
    $categories = CategoryModel::findAll();
    $response->render('course-edition', [ "categories" => $categories ]);
}, [ HasNotAuthMiddleware::class ]);




$app->get('/course-visor', fn($request, $response) => $response->render('course-visor'), [ HasNotAuthMiddleware::class ]);

$app->get('/home', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");
    $role = $session->get("role");
    $response->render('home', [ "id" => $id, "role" => $role ]); 
});


$app->get('/instructor-course-details', fn($request, $response) => $response->render('instructor-course-details'));
$app->get('/instructor-profile-seen-by-others', fn($request, $response) => $response->render('instructor-profile-seen-by-others'));
$app->get('/instructor-profile', fn($request, $response) => $response->render('instructor-profile'));


$app->get('/login', fn($request, $response) => $response->render('login'), [ HasAuthMiddleware::class ]);



$app->get('/password-edition', fn($request, $response) => $response->render('password-edition'), [ HasNotAuthMiddleware::class ]);
$app->get('/payment-method', fn($request, $response) => $response->render('payment-method'));


$app->get('/profile-edition', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");

    $user = UserModel::findOneById($id);
    if (!$user) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $response->render('profile-edition', [ 
        "user" => $user->toObject()
    ]);
}, [ HasNotAuthMiddleware::class ]);


$app->get('/search', fn($request, $response) => $response->render('search'));


$app->get('/signup', function($request, $response) {

    $userRoles = UserRoleModel::findAllByIsPublic(true);

    $response->render('signup', [ "userRoles" => $userRoles ]);
}, [ HasAuthMiddleware::class ]);


$app->get('/profile', function($request, $response) {
    $id = $request->getQuery("id");
    if (!$id || !((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $user = UserModel::findOneById($id);
    if (!$user) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    // Verificar si el usuario somos nosotros o no
    $session = $request->getSession();
    $isMe = false;
    if ($session->get("id") === $user->getId()) {
        $isMe = true;
    }

    $response->render('profile', [ "isMe" => $isMe, "user" => $user->toObject() ]);
});


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
$app->patch('/api/v1/users/:id/password', [ UserController::class, 'updatePassword' ], [ UserUpdatePasswordValidator::class ]);
$app->delete('/api/v1/users/:id', [ UserController::class, 'remove' ]); // !!!
$app->post('/api/v1/users/email', [ UserController::class, 'checkEmailExists' ]);


// Images
$app->get('/api/v1/images/:id', [ ImageController::class, 'getOne' ]);

$app->post('/api/v1/images', [ ImageController::class, 'create' ]);
$app->put('/api/v1/images/:id', [ ImageController::class, 'update' ]);
$app->delete('/api/v1/images/:id', [ ImageController::class, 'remove' ]);


// Videos
$app->get('/api/v1/videos/:id', [ VideoController::class, 'getOne' ]);
$app->post('/api/v1/videos', [ VideoController::class, 'create' ]);


// Documents
$app->get('/api/v1/documents/:id', [ DocumentController::class, 'getOne' ]);
$app->post('/api/v1/documents', [ DocumentController::class, 'create' ]);


// Links
$app->get('/api/v1/links/:id', [ LinkController::class, 'getOne' ]);
$app->post('/api/v1/links', [ LinkController::class, 'create' ]);



// Courses
$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);
$app->get('/api/v1/courses/:id', [ CourseController::class, 'getOne' ]);
//$app->get('/api/v1/users/:id/courses', [ CourseController::class, 'getAllByUser' ]);


$app->post('/api/v1/courses', [ CourseController::class, 'create' ], [ ApiInstructorMiddleware::class ]);
$app->put('/api/v1/courses/:id', [ CourseController::class, 'update' ], [ ApiInstructorMiddleware::class ]);
$app->delete('/api/v1/courses/:id', [ CourseController::class, 'remove' ], [ ApiInstructorMiddleware::class ]);



// Levels
$app->get('/api/v1/levels/:id', [ LevelController::class, 'show' ]);

$app->post('/api/v1/levels', [ LevelController::class, 'create' ], [ ApiInstructorMiddleware::class, LevelCreationValidator::class ]);

$app->put('/api/v1/levels/:id', [ LevelController::class, 'update' ], [ ApiInstructorMiddleware::class ]);
$app->delete('/api/v1/levels/:id', [ LevelController::class, 'delete' ], [ ApiInstructorMiddleware::class ]);

// Lessons
$app->get('/api/v1/lessons/:id', [ LessonController::class, 'show' ]);
$app->post('/api/v1/lessons', [ LessonController::class, 'create' ], [ ApiInstructorMiddleware::class ]);
$app->put('/api/v1/lessons/:id', [ LessonController::class, 'update' ], [ ApiInstructorMiddleware::class ]);
$app->delete('/api/v1/lessons/:id', [ LessonController::class, 'delete' ], [ ApiInstructorMiddleware::class ]);


// Categories
$app->post('/api/v1/categories', [ CategoryController::class, 'create' ], [ AuthMiddleware::class, CategoryCreationValidator::class ]);
$app->put('/api/v1/categories/:id', [ CategoryController::class, 'update' ], [ CategoryUpdateValidator::class ]);
$app->delete('/api/v1/categories/:id', [ CategoryController::class, 'delete' ], [ ApiAdminMiddleware::class ]);

// Messages


$app->run();
