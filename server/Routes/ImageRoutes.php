<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ImageController;

$app->get('/api/v1/images/:id', [ ImageController::class, 'getOne' ]);
$app->post('/api/v1/images', [ ImageController::class, 'create' ]);
$app->put('/api/v1/images/:id', [ ImageController::class, 'update' ]);
$app->delete('/api/v1/images/:id', [ ImageController::class, 'remove' ]);
