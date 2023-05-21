<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LinkController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

$app->get("/api/v1/links/:id", [ LinkController::class, "getOne" ]);

// TODO:
/**
 * Actualiza un enlace
 */
$app->put("/api/v1/links/:id", [ LinkController::class, "update" ], [
    [ AuthApiMiddleware::class, true ]
]);

$app->post("/api/v1/lessons/:id/links", [ LinkController::class, "putLessonLink" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);

$app->delete("/api/v1/links/:id", [ LinkController::class, "delete" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ]
]);