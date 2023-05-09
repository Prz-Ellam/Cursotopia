<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\VideoController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

/**
 * Obtiene un video en base a su identificador único
 */
$app->get("/api/v1/videos/:id", [ VideoController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Crea un video
 */
//$app->post("/api/v1/videos", [ VideoController::class, "create" ], [
//    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ]
//]);

/**
 * Actualiza un video
 */
$app->put("/api/v1/videos/:id", [ VideoController::class, "update" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ]
]);