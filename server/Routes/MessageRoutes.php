<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\MessageController;
use Cursotopia\Middlewares\AuthApiMiddleware;

/**
 * Obtiene todos los mensajes de un chat
 */
$app->get("/api/v1/chats/:chatId/messages", [ MessageController::class, "getAllByChat" ], [
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Crea un mensaje
 */
$app->post("/api/v1/chats/:chatId/messages", [ MessageController::class, "create" ], [
    [ AuthApiMiddleware::class, true ]
]);