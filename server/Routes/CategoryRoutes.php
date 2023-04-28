<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\CategoryController;
use Cursotopia\Middlewares\AuthMiddleware;
use Cursotopia\Middlewares\WebAdminMiddleware;

$app->get('/categories', 
    fn($request, $response) => $response->render('admin-categories'),
    [ [ WebAdminMiddleware::class ] ]);

$app->get('/admin-categories', function($request, $response) {
    $response->render("admin-categories");
});

$app->get('/api/v1/categories', [ CategoryController::class, 'findAll' ], [ [ AuthMiddleware::class ] ]);
$app->post('/api/v1/categories', [ CategoryController::class, 'create' ], [ [ AuthMiddleware::class ] ]);
$app->put('/api/v1/categories/:id', [ CategoryController::class, 'update' ]);
$app->delete('/api/v1/categories/:id', [ CategoryController::class, 'delete' ]);
