<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\DocumentController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

/**
 * Obtener un documento en base a su identificador único
 */
$app->get("/api/v1/documents/:id", [ DocumentController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Crea un documento
 */
//$app->post("/api/v1/documents", [ DocumentController::class, "create" ], [
//    [ AuthApiMiddleware::class, true ]
//]);

/**
 * Actualiza un documento
 */
$app->post("/api/v1/documents/:id", [ DocumentController::class, "update" ], [
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Pone un documento en una lección
 */
$app->post("/api/v1/lessons/:id/documents", [ DocumentController::class, "putLessonDocument" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);

$app->delete("/api/v1/documents/:id", [ DocumentController::class, "delete" ], [
    [ AuthApiMiddleware::class, true ]
]);