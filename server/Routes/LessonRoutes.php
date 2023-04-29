<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\DocumentController;
use Cursotopia\Controllers\LessonController;
use Cursotopia\Controllers\VideoController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

// API
/**
 * Obtiene una lección en base a su identificador único
 */
$app->get("/api/v1/lessons/:id", [ LessonController::class, "getOne" ], [
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Crea una lección
 */
$app->post("/api/v1/lessons", [ LessonController::class, "create" ], [
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ],
    [ VideoController::class, "create" ],
    [ ImageController::class, "create" ],
    [ DocumentController::class, "create" ],
    [ PayloadMiddleware::class ],
    // [ JsonSchemaMiddleware::class, 'LessonCreateValidator' ],  
]);

/**
 * Actualiza una lección
 */
$app->put("/api/v1/lessons/:id", [ LessonController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "LessonCreateValidator" ], 
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Elimina una lección
 */
$app->delete("/api/v1/lessons/:id", [ LessonController::class, "delete" ], [ 
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Marca como completada una lección
 */
$app->put("/api/v1/lessons/:id/complete", [ LessonController::class, "complete" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Marca como visitada una lección
 */
$app->put("/api/v1/lessons/:id/visit", [ LessonController::class, "visit" ], [
    [ ValidateIdMiddleware::class ]
]);