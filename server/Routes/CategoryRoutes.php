<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CategoryController;
use Cursotopia\Middlewares\ApiAdminMiddleware;
use Cursotopia\Middlewares\AuthMiddleware;

$app->post('/api/v1/categories', [ CategoryController::class, 'create' ], [ [ AuthMiddleware::class ] ]);
$app->put('/api/v1/categories/:id', [ CategoryController::class, 'update' ]);
$app->delete('/api/v1/categories/:id', [ CategoryController::class, 'delete' ]);
