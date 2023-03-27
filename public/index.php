<?php

use Bloom\Application;

define('BLOOM_START', microtime(true));
define('DEBUG', true);
define('BASE_DIR', __DIR__);
define('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]);
define('UPLOADS_DIR', DOCUMENT_ROOT . '/uploads');
define('TIMEZONE', "America/Monterrey");

require_once "../vendor/autoload.php";

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

date_default_timezone_set(TIMEZONE);

$app = Application::app(DOCUMENT_ROOT);
$app->setNotFound(function($request, $response) { $response->setStatus(404)->render('404'); });

foreach (glob("../server/Routes/*.php") as $route) {
    include_once $route; 
}

$app->run();