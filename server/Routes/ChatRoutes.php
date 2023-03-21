<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ChatController;
use Cursotopia\Controllers\MessageController;

// TODO: Raro
$app->post("/api/v1/chats/find", [ ChatController::class, 'getChatByParticipants' ]);

$app->get("/api/v1/chats/:chatId/messages", [ MessageController::class, "getAllByChat" ]);
$app->post("/api/v1/chats/:chatId/messages", [ MessageController::class, "create" ]);