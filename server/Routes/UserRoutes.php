<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\AuthController;
use Cursotopia\Controllers\UserController;
use Cursotopia\Middlewares\HasAuthMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Models\UserModel;
use Cursotopia\Models\UserRoleModel;

$app->get('/login', fn($request, $response) => $response->render('login'), 
[ [ HasAuthMiddleware::class ] ]);

$app->get('/signup', function($request, $response) {
    $userRoles = UserRoleModel::findAllByIsPublic(true);
    $response->render('signup', [ "userRoles" => $userRoles ]);
}, [ [ HasAuthMiddleware::class ] ]);

$app->get('/profile', function($request, $response) {
    $id = $request->getQuery("id");
    if (!$id || !((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $user = UserModel::findOneById($id);
    if (!$user) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    // Verificar si el usuario somos nosotros o no
    $session = $request->getSession();
    $isMe = false;
    if ($session->get("id") === $user->getId()) {
        $isMe = true;
    }
    
    $response->render('profile', [ "isMe" => $isMe, "user" => $user->toObject() ]);
});

$app->get('/profile-edition', function($request, $response) {
    $session = $request->getSession();
    $id = $session->get("id");

    $user = UserModel::findOneById($id);
    if (!$user) {
        $response
            ->setStatus(404)
            ->render('404');
        return;
    }

    $response->render('profile-edition', [ 
        "user" => $user->toObject()
    ]);
}, [ [ HasNotAuthMiddleware::class ] ]);

$app->get('/password-edition', fn($request, $response) => $response->render('password-edition'), 
[ [ HasNotAuthMiddleware::class ] ]);

$app->get('/blocked-users', fn($request, $response) => $response->render('blocked-users'));

$app->post('/api/v1/auth', [ AuthController::class, 'login' ], 
    [ [ JsonSchemaMiddleware::class, 'LoginValidator' ] ]);
$app->get('/api/v1/logout', [ AuthController::class, 'logout' ]);

// Users
$app->get("/api/v1/users", [ UserController::class, 'getAll' ]);
$app->get('/api/v1/users/:id', [ UserController::class, 'getOne' ]);

$app->post('/api/v1/users', [ UserController::class, 'create' ], 
    [ [ JsonSchemaMiddleware::class, 'SignupValidator' ] ]);

$app->patch('/api/v1/users/:id', [ UserController::class, 'update' ]);
$app->patch('/api/v1/users/:id/password', [ UserController::class, 'updatePassword' ]);
$app->delete('/api/v1/users/:id', [ UserController::class, 'remove' ]); // !!!
$app->post('/api/v1/users/email', [ UserController::class, 'checkEmailExists' ]);
