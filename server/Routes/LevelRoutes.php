<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LevelController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

/**
 * Obtiene un nivel en base a su identificador único
 */
$app->get("/api/v1/levels/:id", [ LevelController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Crea un nivel
 */
$app->post("/api/v1/levels", [ LevelController::class, "create" ], [
    [ JsonSchemaMiddleware::class, "LevelCreateValidator" ], 
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Actualiza un nivel
 */
$app->put("/api/v1/levels/:id", [ LevelController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "LevelUpdateValidator" ],
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Elimina un nivel
 */
$app->delete("/api/v1/levels/:id", [ LevelController::class, "delete" ], [ 
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);
