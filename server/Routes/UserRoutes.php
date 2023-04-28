<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\AuthController;
use Cursotopia\Controllers\UserController;
use Cursotopia\Middlewares\AuthMiddleware;
use Cursotopia\Middlewares\HasAuthMiddleware;
use Cursotopia\Middlewares\HasNotAuthMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;

// Web
$app->get("/login", [ UserController::class, "loginWeb" ], [ 
    [ HasAuthMiddleware::class ] 
]);

$app->get("/signup", [ UserController::class, "signup" ], [ 
    [ HasAuthMiddleware::class ] 
]);

$app->get("/profile", [ UserController::class, "profile" ]);

// TODO
// HasNotAuthMiddleware es un nombre no muy descriptivo de lo que de verdad hace
$app->get("/profile-edition", [ UserController::class, "profileEdition" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

$app->get("/password-edition", [ UserController::class, "passwordEdition" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

// TODO
// Le faltan middlewares
$app->get("/blocked-users", [ UserController::class, "blockedUsers" ]);

// API
/**
 * Iniciar sesión
 */
$app->post("/api/v1/auth", [ AuthController::class, "login" ], [ 
    [ JsonSchemaMiddleware::class, "LoginValidator" ] 
]);

/**
 * Cerrar sessión
 */
$app->get("/api/v1/logout", [ AuthController::class, "logout" ]);

/**
 * Obtener todos los usuarios
 */
$app->get("/api/v1/users", [ UserController::class, "getAll" ]);

/**
 * Obtener todos los usuarios con rol de instructor
 */
$app->get("/api/v1/users/instructors", [ UserController::class, "getAllInstructors" ]);

/**
 * Obtener un usuario en base a su identificador único
 */
$app->get("/api/v1/users/:id", [ UserController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

/**
 * Crea un usuario
 */
$app->post("/api/v1/users", [ UserController::class, "create" ],  [
    //[ ImageController::class, "a" ],
    [ JsonSchemaMiddleware::class, "SignupValidator" ] 
]);

/**
 * Actualiza un usuario
 */
$app->patch("/api/v1/users/:id", [ UserController::class, "update" ], [ 
    [ JsonSchemaMiddleware::class, "UpdateUserValidator" ],
    [ ValidateIdMiddleware::class ],
    [ AuthMiddleware::class ]
]);

/**
 * Actualiza la contraseña de un usuario
 */
$app->patch("/api/v1/users/:id/password", [ UserController::class, "updatePassword" ], [
    [ JsonSchemaMiddleware::class, "UpdatePasswordValidator" ],
    [ ValidateIdMiddleware::class ],
    [ AuthMiddleware::class ]
]);

/**
 * Elimina un usuario
 */
$app->delete("/api/v1/users/:id", [ UserController::class, "remove" ]); // !!!

/**
 * Verifica si un correo electrónico es usado por algun usuario
 */
$app->post("/api/v1/users/email", [ UserController::class, "checkEmailExists" ]);
