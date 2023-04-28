<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthMiddleware;

$app->get("/payment-method", [ ReviewController::class, "paymentMethod" ]);

$app->post('/api/v1/reviews', [ ReviewController::class, 'create' ], [ [ AuthMiddleware::class ] ]);
