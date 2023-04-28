<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LevelController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

/**
 * Obtiene un nivel en base a su identificador único
 */
$app->get("/api/v1/levels/:id", [ LevelController::class, "getOne" ]);

/**
 * Crea un nivel
 */
$app->post("/api/v1/levels", [ LevelController::class, "create" ], [
    [ JsonSchemaMiddleware::class, "LevelCreateValidator" ], 
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Actualiza un nivel
 */
$app->put("/api/v1/levels/:id", [ LevelController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "LevelUpdateValidator" ],
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Elimina un nivel
 */
$app->delete("/api/v1/levels/:id", [ LevelController::class, "delete" ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);
