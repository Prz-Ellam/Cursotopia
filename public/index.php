<?php

use Bloom\Application;
use Dotenv\Dotenv;

require_once "../vendor/autoload.php";
Dotenv::createImmutable("..")->load();

$_ENV["VIEW_PATH"] = dirname(__DIR__, 1) . "/views";
$app = Application::app();
$app->getTemplateEngine()->setExtension("html");

$app->get('/', fn($request, $response) => $response->redirect('/home.html'));
$app->get('/admin-categories.html', fn($request, $response) => $response->render('admin-categories'));
$app->get('/admin-courses.html', fn($request, $response) => $response->render('admin-courses'));
$app->get('/admin-home.html', fn($request, $response) => $response->render('admin-home'));
$app->get('/blocked-users.html', fn($request, $response) => $response->render('blocked-users'));
$app->get('/certificate.html', fn($request, $response) => $response->render('certificate'));
$app->get('/chat.html', fn($request, $response) => $response->render('chat'));
$app->get('/course-creation.html', fn($request, $response) => $response->render('course-creation'));
$app->get('/course-details.html', fn($request, $response) => $response->render('course-details'));
$app->get('/course-edition.html', fn($request, $response) => $response->render('course-edition'));
$app->get('/course-visor.html', fn($request, $response) => $response->render('course-visor'));
$app->get('/home.html', fn($request, $response) => $response->render('home'));
$app->get('/instructor-course-details.html', fn($request, $response) => $response->render('instructor-course-details'));
$app->get('/instructor-profile-seen-by-others.html', fn($request, $response) => $response->render('instructor-profile-seen-by-others'));
$app->get('/instructor-profile.html', fn($request, $response) => $response->render('instructor-profile'));
$app->get('/login.html', fn($request, $response) => $response->render('login'));
$app->get('/password-edition.html', fn($request, $response) => $response->render('password-edition'));
$app->get('/payment-method.html', fn($request, $response) => $response->render('payment-method'));
$app->get('/profile-edition.html', fn($request, $response) => $response->render('profile-edition'));
$app->get('/search.html', fn($request, $response) => $response->render('search'));
$app->get('/signup.html', fn($request, $response) => $response->render('signup'));
$app->get('/student-profile-seen-by-others.html', fn($request, $response) => $response->render('student-profile-seen-by-others'));
$app->get('/student-profile.html', fn($request, $response) => $response->render('student-profile'));

$app->run();
