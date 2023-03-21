<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LessonController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;

$app->get('/api/v1/lessons/:id', [ LessonController::class, 'show' ]);
$app->post('/api/v1/lessons', [ LessonController::class, 'create' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->put('/api/v1/lessons/:id', [ LessonController::class, 'update' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->delete('/api/v1/lessons/:id', [ LessonController::class, 'delete' ], [ [ ApiInstructorMiddleware::class ] ]);
