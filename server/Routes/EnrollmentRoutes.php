<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\EnrollmentController;
use Cursotopia\Middlewares\AuthWebMiddleware;
use Cursotopia\ValueObjects\Roles;

// Web
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
$app->post("/api/v1/enrollments", [ EnrollmentController::class, "create" ]);
