<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ChatController;
use Cursotopia\Middlewares\AuthApiMiddleware;
use Cursotopia\Middlewares\AuthWebMiddleware;

/**
 * Página del chat
 */
$app->get("/chat", [ ChatController::class, "chat" ], [ 
    [ AuthWebMiddleware::class, true ] 
]);

/**
 * Busca el chat de un usuario
 */
$app->post("/api/v1/chats/find", [ ChatController::class, "getChatByParticipants" ], [
    [ AuthApiMiddleware::class, true ]
]);

/**
 * Obtiene todos los chats de un usuario
 */
$app->get("/api/v1/users/chats", [ ChatController::class, "getUserChats" ], [
    [ AuthApiMiddleware::class, true ]
]);