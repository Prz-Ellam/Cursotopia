<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\LinkController;

$app->get('/api/v1/links/:id', [ LinkController::class, 'getOne' ]);
$app->post('/api/v1/links', [ LinkController::class, 'create' ]);
