<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthMiddleware;

/**
 * Página para comprar un curso
 */
$app->get("/payment-method", [ ReviewController::class, "paymentMethod" ]);

/**
 * Crea una reseña
 */
$app->post('/api/v1/reviews', [ ReviewController::class, 'create' ], [ 
    [ AuthMiddleware::class ] 
]);
