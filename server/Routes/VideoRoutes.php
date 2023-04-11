<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\VideoController;
use Cursotopia\Middlewares\ValidateIdMiddleware;

// Obtener un video
$app->get('/api/v1/videos/:id', [ VideoController::class, 'getOne' ], [
    [ ValidateIdMiddleware::class ]
]);

// Crear un video
$app->post('/api/v1/videos', [ VideoController::class, 'create' ]);