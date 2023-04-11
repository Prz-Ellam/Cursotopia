<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LessonController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;

$app->get('/api/v1/lessons/:id', [ LessonController::class, 'show' ]);

// Crear una lección
$app->post('/api/v1/lessons', [ LessonController::class, 'create' ], [
    [ JsonSchemaMiddleware::class, 'LessonCreateValidator' ],  
    [ ApiInstructorMiddleware::class ] 
]);

// Actualizar una lección
$app->put('/api/v1/lessons/:id', [ LessonController::class, 'update' ], [ 
    [ JsonSchemaMiddleware::class, 'LessonCreateValidator' ], 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

// Eliminar una lección
$app->delete('/api/v1/lessons/:id', [ LessonController::class, 'delete' ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);
