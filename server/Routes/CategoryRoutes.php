<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CategoryController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;
use Cursotopia\ValueObjects\Roles;

/**
 * Pagina del administrador para la gestion de categorías
 */
$app->get("/admin/categories", [ CategoryController::class, "categories" ], [ 
    [ AuthWebMiddleware::class, true, Roles::ADMIN->value ] 
]);

/**
 * Obtiene todas las categorías
 */
$app->get("/api/v1/categories", [ CategoryController::class, "getAll" ]);

/**
 * Obtiene todas las categorías approvadas
 */
$app->get("/api/v1/categories/approved", [ CategoryController::class, "getApproved" ]);

/**
 * Obtiene todas las categorías no aprobadas
 */
$app->get("/api/v1/categories/notApproved", [ CategoryController::class, "getNotApproved" ]);

/**
 * Obtiene todas las categorías no activas
 */
$app->get("/api/v1/categories/notActive", [ CategoryController::class, "getNotActive" ]);

/**
 * Checa si una categoría existe por su nombre
 */
$app->post("/api/v1/categories/name", [ CategoryController::class, "checkNameExists" ]);

/**
 * Obtiene una categoría
 */
$app->get("/api/v1/categories/:id", [ CategoryController::class, "findById" ]);


/**
 * Crea una categoría
 */
$app->post("/api/v1/categories", [ CategoryController::class, "create" ], [ 
    [ AuthApiMiddleware::class, true ] 
]);

/**
 * Actualiza una categoría
 */
$app->put("/api/v1/categories/:id", [ CategoryController::class, "update" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

/**
 * Elimina una categoría
 */
$app->delete("/api/v1/categories/:id", [ CategoryController::class, "delete" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

// TODO:
/**
 * Aprobar una categoría
 */
$app->put("/api/v1/categories/:id/approve", [ CategoryController::class, "approve" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

/**
 * Denegar una categoría
 */

$app->put("/api/v1/categories/:id/deny", [ CategoryController::class, "deny" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

/**
 * Activar una categoría
 */

 $app->put("/api/v1/categories/:id/activate", [ CategoryController::class, "activate" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

/**
 * Desactivar una categoría
 */

 $app->put("/api/v1/categories/:id/deactivate", [ CategoryController::class, "deactivate" ], [
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

