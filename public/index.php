<?php

use Bloom\Application;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\WebAdminMiddleware;
use Cursotopia\Repositories\CourseRepository;

define('BLOOM_START', microtime(true));

require_once "../vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Monterrey");

$app = Application::app(dirname(__DIR__, 1));

$app->setNotFound(function($request, $response) { $response->render('404'); });

foreach (glob("../server/Routes/*.php") as $route) {
    include_once $route; 
}

$app->get('/', fn($request, $response) => $response->redirect('/home'));
$app->get('/categories', 
    fn($request, $response) => $response->render('admin-categories'),
    [ [ WebAdminMiddleware::class ] ]);

$app->get('/admin-courses', fn($request, $response) => $response->render('admin-courses'));
$app->get('/chat', fn($request, $response) => $response->render('chat'), [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/home', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");
    $role = $session->get("role");

    $courseRepository = new CourseRepository();
    $courses = $courseRepository->findAllOrderByCreatedAt();

    $response->render('home', [ 
        "id" => $id, 
        "role" => $role,
        "lastPublishedcourses" => $courses
    ]);
});

$app->get('/instructor-course-details', fn($request, $response) => $response->render('instructor-course-details'));
$app->get('/search', fn($request, $response) => $response->render('search'));

$app->run();