<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\HomeController;
use Cursotopia\Middlewares\HasNotAuthMiddleware;

$app->get('/', fn($request, $response) => $response->redirect('/home'));
$app->get('/chat', [ HomeController::class, 'chat' ], 
[ 
    [ HasNotAuthMiddleware::class ] 
]);
$app->get('/home', [ HomeController::class, 'home' ]);
$app->get('/search', [ HomeController::class, 'search' ]);
