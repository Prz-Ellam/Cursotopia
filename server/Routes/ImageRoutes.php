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
 * Crea una imagen
 */
$app->post("/api/v1/images", [ ImageController::class, "create" ], [
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Actualiza una imagen
 */
$app->put("/api/v1/images/:id", [ ImageController::class, "update" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true ]
]);

//$app->delete('/api/v1/images/:id', [ ImageController::class, 'remove' ]);
