<?php

use Bloom\Application;

require_once "../vendor/autoload.php";

$app = Application::app();

$app->get('/', function() {
    echo "GET OK";
});
$app->post('/home', function() {
    echo "POST OK";
});

$app->run();

//header("Content-Type: application/json");
//echo json_encode($_SERVER);

echo $_SERVER["REQUEST_URI"];
echo "<br>";
echo $_SERVER["REQUEST_METHOD"];