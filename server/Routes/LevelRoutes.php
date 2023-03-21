<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LevelController;
use Cursotopia\Middlewares\ApiInstructorMiddleware;

$app->get('/api/v1/levels/:id', [ LevelController::class, 'show' ]);
$app->post('/api/v1/levels', [ LevelController::class, 'create' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->put('/api/v1/levels/:id', [ LevelController::class, 'update' ], [ [ ApiInstructorMiddleware::class ] ]);
$app->delete('/api/v1/levels/:id', [ LevelController::class, 'delete' ], [ [ ApiInstructorMiddleware::class ] ]);
