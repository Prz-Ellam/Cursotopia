<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\EnrollmentController;

// Web
$app->get("/certificate", [ EnrollmentController::class, "certificate" ]);

// API
/**
 * Crea una inscripción
 */
$app->post("/api/v1/enrollments", [ EnrollmentController::class, "create" ]);
