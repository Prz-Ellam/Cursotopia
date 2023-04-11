<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ImageController;
use Cursotopia\Middlewares\ValidateIdMiddleware;

$app->get('/api/v1/images/:id', [ ImageController::class, 'getOne' ], [
    [ ValidateIdMiddleware::class ]
]);

$app->post('/api/v1/images', [ ImageController::class, 'create' ]);

$app->put('/api/v1/images/:id', [ ImageController::class, 'update' ], [
    [ ValidateIdMiddleware::class ]
]);

//$app->delete('/api/v1/images/:id', [ ImageController::class, 'remove' ]);
