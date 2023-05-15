<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CourseController;
use Cursotopia\Controllers\ImageController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\PayloadMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

// Web
/**
 * Página para crear un curso
 */
// Solo instructores
$app->get("/course-creation", [ CourseController::class, "webCreate" ], [ 
    [ AuthWebMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Página para mostrar los detalles del curso
 */
$app->get("/course-details", [ CourseController::class, "details" ]);

/**
 * Página para editar un curso
 */
// Solo instructores
$app->get("/course-edition", [ CourseController::class, "webUpdate" ], [ 
    [ AuthWebMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Página para visualizar las lecciones de los cursos
 */
$app->get("/course-visor", [ CourseController::class, "visor" ], [ 
    [ AuthWebMiddleware::class ] 
]);

/**
 * Página del administrador para gestionar cursos
 */
// Solo administradores
$app->get("/admin/courses", [ CourseController::class, "admin" ], [
    [ AuthWebMiddleware::class, true, Roles::ADMIN->value ] 
]);

/**
 * Página para ver los estudiantes de un curso
 */
$app->get("/instructor-course-details", [ CourseController::class, "courseDetails" ]);

/**
 * Pagina de la busqueda de cursos
 */
$app->get("/search", [ CourseController::class, "search" ]);


// API
//$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);

/**
 * Obtiene un curso en base a su identificador único
 */
$app->get("/api/v1/courses/:id", [ CourseController::class, "getOne" ]);

$app->get("/api/v1/courses", [ CourseController::class, "findByNotApproved" ]);

/**
 * Crea un curso
 */
$app->post("/api/v1/courses", [ CourseController::class, "create" ], [ 
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ], 
    [ ImageController::class, "create" ],
    [ PayloadMiddleware::class ],
    [ JsonSchemaMiddleware::class, "CourseCreateValidator" ]
]);

/**
 * Actualiza un curso
 */
$app->put("/api/v1/courses/:id", [ CourseController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "CourseUpdateValidator" ],
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Deshabilita un curso
 */
$app->delete("/api/v1/courses/:id", [ CourseController::class, "delete" ], [ 
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Confirmar la creacion del curso
 */
$app->put("/api/v1/courses/:id/confirm", [ CourseController::class, "confirm" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::INSTRUCTOR->value ] 
]);

/**
 * Aprueba un curso
 */
$app->put("/api/v1/courses/:id/approve", [ CourseController::class, "approve" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ] 
]);

/**
 * Denegar un curso
 */
$app->put("/api/v1/courses/:id/deny", [ CourseController::class, "deny" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ] 
]);
// TODO:
// Validar en los actualizados o eliminados que le pertenezca al usuario el recurso