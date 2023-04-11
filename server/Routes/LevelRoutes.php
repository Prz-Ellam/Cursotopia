<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LevelController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;

$app->get('/api/v1/levels/:id', [ LevelController::class, 'show' ]);

// Crear un nivel
$app->post('/api/v1/levels', [ LevelController::class, 'create' ], [
    [ JsonSchemaMiddleware::class, 'LevelCreateValidator' ], 
    [ ApiInstructorMiddleware::class ] 
]);

// Actualizar un nivel
$app->put('/api/v1/levels/:id', [ LevelController::class, 'update' ], [ 
    [ JsonSchemaMiddleware::class, 'LevelUpdateValidator' ],
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

// Eliminar un nivel
$app->delete('/api/v1/levels/:id', [ LevelController::class, 'delete' ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);
