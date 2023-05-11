<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ImageController;
use Cursotopia\Controllers\UserController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;
use Cursotopia\Middlewares\JsonSchemaMiddleware;
use Cursotopia\Middlewares\PayloadMiddleware;
use Cursotopia\Middlewares\ValidateIdMiddleware;
use Cursotopia\ValueObjects\Roles;

// Web
/**
 * Página de inicio de sesión
 */
$app->get("/login", [ UserController::class, "loginWeb" ], [ 
    [ AuthWebMiddleware::class, false ] 
]);

/**
 * Página del registro de usuarios
 */
$app->get("/signup", [ UserController::class, "signup" ], [ 
    [ AuthWebMiddleware::class, false ] 
]);

/**
 * Página de perfil de usuario
 */
$app->get("/profile", [ UserController::class, "profile" ]);

/**
 * Página de edición de perfil
 */
$app->get("/profile-edition", [ UserController::class, "profileEdition" ], [ 
    [ AuthWebMiddleware::class, true ] 
]);

/**
 * Página de edición de contraseña
 */
$app->get("/password-edition", [ UserController::class, "passwordEdition" ], [ 
    [ AuthWebMiddleware::class ] 
]);

/**
 * Bloquea usuarios
 */
$app->get("/blocked-users", [ UserController::class, "blockedUsers" ], [
    [ AuthWebMiddleware::class ] 
]);

// API
/**
 * Iniciar sesión
 */
$app->post("/api/v1/auth", [ UserController::class, "login" ], [
    [ AuthApiMiddleware::class, false ],
    [ JsonSchemaMiddleware::class, "LoginValidator" ] 
]);

/**
 * Cerrar sessión
 */
$app->get("/api/v1/logout", [ UserController::class, "logout" ], [
    [ AuthApiMiddleware::class ] 
]);

/**
 * Obtener todos los usuarios
 */
$app->get("/api/v1/users", [ UserController::class, "getAll" ]);

/**
 * Obtener todos los usuarios con rol de instructor
 */
$app->get("/api/v1/users/instructors", [ UserController::class, "getAllInstructors" ]);

$app->get("/api/v1/users/blocked", [ UserController::class, "findBlockedUsers" ]);

$app->get("/api/v1/users/unblocked", [ UserController::class, "findUnblockedUsers" ]);


/**
 * Obtener un usuario en base a su identificador único
 */
$app->get("/api/v1/users/:id", [ UserController::class, "getOne" ], [
    [ ValidateIdMiddleware::class ]
]);

$app->put("/api/v1/users/:id/block", [ UserController::class, "disableUser" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

$app->put("/api/v1/users/:id/unblock", [ UserController::class, "enableUser" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);
/**
 * Registro de usuarios
 */
$app->post("/api/v1/users", [ UserController::class, "create" ],  [
    [ AuthApiMiddleware::class, false ], 
    [ ImageController::class, "create" ],
    [ PayloadMiddleware::class ],
    [ JsonSchemaMiddleware::class, "SignupValidator" ] 
]);

/**
 * Actualiza un usuario
 */
$app->patch("/api/v1/users/:id", [ UserController::class, "update" ], [ 
    [ AuthApiMiddleware::class ],
    [ JsonSchemaMiddleware::class, "UpdateUserValidator" ],
    [ ValidateIdMiddleware::class ]
]);

/**
 * Actualiza la contraseña de un usuario
 */
$app->patch("/api/v1/users/:id/password", [ UserController::class, "updatePassword" ], [
    [ AuthApiMiddleware::class ],
    [ JsonSchemaMiddleware::class, "UpdatePasswordValidator" ],
    [ ValidateIdMiddleware::class ]
]);

/**
 * Verifica si un correo electrónico es usado por algun usuario
 */
$app->post("/api/v1/users/email", [ UserController::class, "checkEmailExists" ]);

/**
 * Bloquear a un usuario
 */
$app->put("/api/v1/users/:id/disable", [ UserController::class, "disableUser" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);

/**
 * Desbloquear a un usuario
 */
$app->put("/api/v1/users/:id/enable", [ UserController::class, "enableUser" ], [
    [ ValidateIdMiddleware::class ],
    [ AuthApiMiddleware::class, true, Roles::ADMIN->value ]
]);