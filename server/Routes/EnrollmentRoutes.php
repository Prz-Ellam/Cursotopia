<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\EnrollmentController;

// Web
$app->get("/certificate", [ EnrollmentController::class, "certificate" ]);

// API
$app->post("/api/v1/enrollments", [ EnrollmentController::class, "create" ]);
