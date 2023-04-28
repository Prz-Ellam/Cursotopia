<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CourseController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

// Web
$app->get("/course-creation", [ CourseController::class, "webCreate" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

$app->get("/course-details", [ CourseController::class, "details" ]);

$app->get("/course-edition", [ CourseController::class, "webUpdate" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

$app->get("/course-visor", [ CourseController::class, "visor" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

$app->get("/admin-courses", [ CourseController::class, "admin" ]);

$app->get("/instructor-course-details", [ CourseController::class, "courseDetails" ]);

$app->get("/search", [ CourseController::class, "search" ]);


// API
//$app->get('/api/v1/courses', [ CourseController::class, 'getAll' ]);

/**
 * Obtiene un curso en base a su identificador único
 */
$app->get("/api/v1/courses/:id", [ CourseController::class, 'getOne' ]);
//$app->get('/api/v1/users/:id/courses', [ CourseController::class, 'getAllByUser' ]);

/**
 * Crea un curso
 */
$app->post('/api/v1/courses', [ CourseController::class, 'create' ], [ 
    [ JsonSchemaMiddleware::class, 'CourseCreateValidator' ],
    [ ApiInstructorMiddleware::class ]
]);

/**
 * Actualiza un curso
 */
$app->put('/api/v1/courses/:id', [ CourseController::class, 'update' ], [ 
    [ JsonSchemaMiddleware::class, 'CourseUpdateValidator' ],
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ]
]);

/**
 * Deshabilita un curso
 */
$app->delete('/api/v1/courses/:id', [ CourseController::class, 'delete' ], [ 
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Obtiene muchos cursos en base a una busqueda avanzada
 */
$app->get("/api/v1/courses", [ CourseController::class, "search" ]);

// Confirmar la creacion del curso
$app->put("/api/v1/courses/:id/confirm", [ CourseController::class, "confirm" ], [
    [ ValidateIdMiddleware::class ],
    [ ApiInstructorMiddleware::class ] 
]);

/**
 * Aprueba un curso
 */
$app->put('/api/v1/courses/:id/approve', [ CourseController::class, "approve" ], [
    [ ValidateIdMiddleware::class ]
]);
// TODO:
// Validar en los actualizados o eliminados que le pertenezca al usuario el recurso