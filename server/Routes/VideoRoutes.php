<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\VideoController;

$app->get('/api/v1/videos/:id', [ VideoController::class, 'getOne' ]);
$app->post('/api/v1/videos', [ VideoController::class, 'create' ]);