<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ImageController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

/**
 * Obtiene una imagen en base a su identificador único
 */
$app->get("/api/v1/images/:id", [ ImageController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Actualiza una imagen
 */
$app->put("/api/v1/images/:id", [ ImageController::class, "update" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Pone una imagen en una lección
 */
$app->post("/api/v1/lessons/:id/images", [ ImageController::class, "putLessonImage" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Desactiva una imagen
 */
$app->delete("/api/v1/images/:id", [ ImageController::class, "delete" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);
