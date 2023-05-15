<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\EnrollmentController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\ValueObjects\Roles;

// Web
/**
 * Página para comprar un curso
 */
$app->get("/payment-method", [ EnrollmentController::class, "paymentMethod" ], [
    [ AuthWebMiddleware::class, true ]
]);

/**
 * Página del certificado del curso
 */
$app->get("/certificate", [ EnrollmentController::class, "certificate" ], [
    [ AuthWebMiddleware::class, true, Roles::STUDENT->value ]
]);

// API
/**
 * Crea una inscripción
 */
$app->post("/api/v1/enrollments", [ EnrollmentController::class, "create" ], [
    [ AuthApiMiddleware::class, true, Roles::STUDENT->value ],
    //[ JsonSchemaMiddleware::class, "EnrollmentCreateValidator" ]
]);

/**
 * Paga un curso
 */
$app->post("/api/v1/enrollments/pay", [ EnrollmentController::class, "pay" ], [
    [ AuthApiMiddleware::class, true, Roles::STUDENT->value ],
    //[ JsonSchemaMiddleware::class, "EnrollmentCreateValidator" ]
]);
