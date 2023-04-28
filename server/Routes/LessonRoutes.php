<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LessonController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

// API
/**
 * Obtiene una lección en base a su identificador único
 */
$app->get("/api/v1/lessons/:id", [ LessonController::class, "getOne" ], [
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Crea una lección
 */
$app->post("/api/v1/lessons", [ LessonController::class, "create" ], [
    // [ JsonSchemaMiddleware::class, 'LessonCreateValidator' ],  
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Actualiza una lección
 */
$app->put("/api/v1/lessons/:id", [ LessonController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "LessonCreateValidator" ], 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Elimina una lección
 */
$app->delete("/api/v1/lessons/:id", [ LessonController::class, "delete" ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
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