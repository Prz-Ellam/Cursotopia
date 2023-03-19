<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ReviewController;
use Cursotopia\Middlewares\AuthMiddleware;
use Cursotopia\Repositories\CourseRepository;

$app->get('/payment-method', function($request, $response) {
    $courseId = $request->getQuery("courseId");
    if (!$courseId || !((is_int($courseId) || ctype_digit($courseId)) && (int)$courseId > 0)) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $courseRepository = new CourseRepository();
    $course = $courseRepository->findOneById($courseId);
    if (!$course) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $response->render("payment-method", [ "course" => $course ]);
});

$app->post('/api/v1/reviews', [ ReviewController::class, 'create' ], [ [ AuthMiddleware::class ] ]);
