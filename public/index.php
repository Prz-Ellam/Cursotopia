<?php

use Bloom\Application;
use Cursotopia\Repositories\Repository;

define("BLOOM_START", microtime(true));
define("DEBUG_MODE", true);
define("BASE_DIR", __DIR__);
define("DOCUMENT_ROOT", dirname($_SERVER["DOCUMENT_ROOT"]));
define("UPLOADS_DIR", DOCUMENT_ROOT . "/uploads");
// No funciona debido a la eliminacion del horario de verano
//define("TIMEZONE", "America/Monterrey");
define("TIMEZONE", "Etc/GMT-6");
define("LANG", "es-MX");
define("LOCALE", "es_MX.UTF-8");
define("CHARSET", "UTF-8");

require_once "../vendor/autoload.php";

if (DEBUG_MODE) {
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}

// Codificación de caracteres
ini_set("default_charset", CHARSET);

ini_set("date.timezone", TIMEZONE);
// Horario local
date_default_timezone_set(TIMEZONE);
Locale::setDefault(LANG);
setlocale(LC_TIME, LOCALE);

// Crear la aplicacion
$app = Application::app(DOCUMENT_ROOT);

// Configurar rutas no asignadas
$app->setNotFound(fn($req, $res) => $res->setStatus(404)->render("404"));

// Cargar las rutas
foreach (glob("../server/Routes/*.php") as $route) {
    include_once $route; 
}

// Ejecutar la aplicación
$app->run();