<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\DocumentController;

$app->get('/api/v1/documents/:id', [ DocumentController::class, 'getOne' ]);
$app->post('/api/v1/documents', [ DocumentController::class, 'create' ]);
