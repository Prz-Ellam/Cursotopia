<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

/**
 * Crea una reseña
 */
$app->post("/api/v1/reviews", [ ReviewController::class, "create" ], [ 
    [ AuthApiMiddleware::class, true, Roles::STUDENT->value ],
    [ JsonSchemaMiddleware::class, "ReviewCreateValidator" ]
]);

/**
 * Busca las reseñas de un curso
 */
$app->get("/api/v1/reviews/:courseId/:pageNum/:pageSize", [ ReviewController::class, "getMoreReviews" ]);
$app->get("/api/v1/courses/:courseId/reviews/total", [ ReviewController::class, "getTotalCourseReviews" ]);

/**
 * Elimina una reseña
 */
$app->delete("/api/v1/reviews/:id", [ ReviewController::class, "delete" ], [
    [ AuthApiMiddleware::class, true ],
    [ ValidateIdMiddleware::class ]
]);
