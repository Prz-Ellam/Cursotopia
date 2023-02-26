<?php

use Bloom\Application;
use Dotenv\Dotenv;

require_once "../vendor/autoload.php";
Dotenv::createImmutable("..")->load();

$_ENV["VIEW_PATH"] = dirname(__DIR__, 1) . "/views";
$app = Application::app();
$app->getTemplateEngine()->setExtension("html");

$app->get('/home', fn($request, $response) => $response->render('home'));
$app->get('/login', fn($request, $response) => $response->render('login'));
$app->get('/signup', fn($request, $response) => $response->render('signup'));
$app->get('/course-details', fn($request, $response) => $response->render('course-details'));

$app->run();
