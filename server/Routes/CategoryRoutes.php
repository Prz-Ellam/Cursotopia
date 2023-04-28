<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CategoryController;
use Cursotopia\Middlewares\AuthMiddleware;
use Cursotopia\Middlewares\WebAdminMiddleware;

/**
 * Pagina del administrador para la gestion de categorías
 */
$app->get("/admin/categories", [ CategoryController::class, "categories" ], [ 
    [ WebAdminMiddleware::class ] 
]);

/**
 * Obtiene una categoría en base a su identificador único
 */
$app->get("/api/v1/categories", [ CategoryController::class, "findAll" ], [ 
    [ AuthMiddleware::class ] 
]);

/**
 * Crea una categoría
 */
$app->post("/api/v1/categories", [ CategoryController::class, "create" ], [ 
    [ AuthMiddleware::class ] 
]);

/**
 * Actualiza una categoría
 */
$app->put("/api/v1/categories/:id", [ CategoryController::class, "update" ]);

/**
 * Elimina una categoría
 */
$app->delete("/api/v1/categories/:id", [ CategoryController::class, "delete" ]);
