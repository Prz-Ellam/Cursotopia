<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthWebMiddleware;

/**
 * Página para comprar un curso
 */
$app->get("/payment-method", [ ReviewController::class, "paymentMethod" ]);

/**
 * Crea una reseña
 */
$app->post('/api/v1/reviews', [ ReviewController::class, 'create' ], [ 
    [ AuthWebMiddleware::class ] 
]);
$app->get('/api/v1/reviews/:courseId/:pageNum/:pageSize', [ ReviewController::class, 'getMoreReviews' ]);
$app->delete('/api/v1/reviews/:reviewId', [ ReviewController::class, 'delete' ]);
