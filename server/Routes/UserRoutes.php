<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\UserController;
use Cursotopia\Middlewares\HasAuthMiddleware;
use Cursotopia\Middlewares\Validators\UserSignupValidator;
use Cursotopia\Middlewares\Validators\UserUpdatePasswordValidator;
use Cursotopia\Middlewares\Validators\UserUpdateValidator;

$app->get('/login', fn($request, $response) => $response->render('login'), 
[ [ HasAuthMiddleware::class ] ]);


$app->get('/api/v1/users/:id', [ UserController::class, 'getOne' ]);

$app->post('/api/v1/users', [ UserController::class, 'create' ], [ [ UserSignupValidator::class ] ]);
$app->patch('/api/v1/users/:id', [ UserController::class, 'update' ], [ [ UserUpdateValidator::class ] ]);
$app->patch('/api/v1/users/:id/password', [ UserController::class, 'updatePassword' ], [ [ UserUpdatePasswordValidator::class ] ]);
$app->delete('/api/v1/users/:id', [ UserController::class, 'remove' ]); // !!!
$app->post('/api/v1/users/email', [ UserController::class, 'checkEmailExists' ]);
