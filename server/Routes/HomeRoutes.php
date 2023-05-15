<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\HomeController;

/**
 * Página de inicio
 */
$app->get("/home", [ HomeController::class, "home" ]);

/**
 * Redireccion
 */
$app->get("/", [ HomeController::class, "redirect" ]);
