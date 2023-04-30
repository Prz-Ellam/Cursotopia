<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;

/**
 * Página para comprar un curso
 */
$app->get("/payment-method", [ ReviewController::class, "paymentMethod" ], [
    [ AuthWebMiddleware::class, true ]
]);

/**
 * Crea una reseña
 */
$app->post("/api/v1/reviews", [ ReviewController::class, "create" ], [ 
    [ AuthApiMiddleware::class, true ] 
]);

/**
 * Busca las reseñas de un curso
 */
$app->get("/api/v1/reviews/:courseId/:pageNum/:pageSize", [ ReviewController::class, "getMoreReviews" ]);

/**
 * Elimina una reseña
 */
$app->delete("/api/v1/reviews/:reviewId", [ ReviewController::class, "delete" ], [
    [ AuthApiMiddleware::class, true ]
]);
