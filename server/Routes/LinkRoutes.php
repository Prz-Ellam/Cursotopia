<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LinkController;
use Cursotopia\Middlewares\AuthApiMiddleware;

$app->get("/api/v1/links/:id", [ LinkController::class, "getOne" ]);

/**
 * Crea un enlace
 */
$app->post("/api/v1/links", [ LinkController::class, "create" ], [
    [ AuthApiMiddleware::class, true ]
]);

// TODO:
/**
 * Actualiza un enlace
 */
$app->put("/api/v1/links/:id", [ LinkController::class, "update" ], [
    [ AuthApiMiddleware::class, true ]
]);