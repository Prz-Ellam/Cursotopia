<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\DocumentController;
use Cursotopia\Middlewares\ValidateIdMiddleware;

$app->get('/api/v1/documents/:id', [ DocumentController::class, 'getOne' ], [
    [ ValidateIdMiddleware::class ]
]);

$app->post('/api/v1/documents', [ DocumentController::class, 'create' ]);
