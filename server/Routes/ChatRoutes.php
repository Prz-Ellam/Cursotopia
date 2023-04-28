<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ChatController;
use Cursotopia\Controllers\MessageController;

$app->get("/chat", [ ChatController::class, "chat" ], [ 
    [ HasNotAuthMiddleware::class ] 
]);

// TODO: Raro
$app->post("/api/v1/chats/find", [ ChatController::class, "getChatByParticipants" ]);

/**
 * Obtiene todos los mensajes de un chat
 */
$app->get("/api/v1/chats/:chatId/messages", [ MessageController::class, "getAllByChat" ]);

/**
 * Crea un mensaje
 */
$app->post("/api/v1/chats/:chatId/messages", [ MessageController::class, "create" ]);