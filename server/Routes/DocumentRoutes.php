<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\DocumentController;
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
$app->post("/api/v1/documents", [ DocumentController::class, "create" ]);

// TODO
/**
 * Actualiza un documento
 */
$app->put("/api/v1/documents/:id", [ DocumentController::class, "update" ]);