<?php

use Bloom\Application;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\WebAdminMiddleware;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\ChatRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\MainRepository;

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
$app->get('/chat', function(Request $request, Response $response) { 
    $session = $request->getSession();
    $id = $session->get("id");
    
    $chatRepository = new ChatRepository();
    $chats = $chatRepository->findAllByUserId($id);
    
    $response->render("chat", [
        "chats" => $chats
    ]); 
}, [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/home', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");
    $role = $session->get("role");

    $mainRepository = new MainRepository();
    $stats = $mainRepository->homeStats();

    $courseRepository = new CourseRepository();
    $courses = $courseRepository->findAllOrderByCreatedAt();
    $coursesRates = $courseRepository->findAllOrderByRates();
    $bestSellingCourses = $courseRepository->findAllOrderByEnrollments();

    $response->render('home', [ 
        "id" => $id, 
        "role" => $role,
        "lastPublishedcourses" => $courses,
        "topRatedCourses" => $coursesRates,
        "bestSellingCourses" => $bestSellingCourses,
        "stats" => $stats
    ]);
});

$app->get('/instructor-course-details', fn($request, $response) => $response->render('instructor-course-details'));
$app->get('/search', function($request, $response) {
    $page = $request->getQuery("page");
    
    $courseRepository = new CourseRepository();
    $courses = $courseRepository->findAllOrderByCreatedAt();

    $categories = CategoryModel::findAll();

    $response->render("search", [
        "courses" => $courses,
        "categories" => $categories
    ]);
});

$app->run();