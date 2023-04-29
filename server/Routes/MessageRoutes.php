<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\MessageController;

/**
 * Obtiene todos los mensajes de un chat
 */
$app->get("/api/v1/chats/:chatId/messages", [ MessageController::class, "getAllByChat" ]);

/**
 * Crea un mensaje
 */
$app->post("/api/v1/chats/:chatId/messages", [ MessageController::class, "create" ]);