<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\EnrollmentController;

$app->get('/certificate', fn($request, $response) => $response->render('certificate'));

$app->post('/api/v1/enrollments', [ EnrollmentController::class, 'create' ]);
