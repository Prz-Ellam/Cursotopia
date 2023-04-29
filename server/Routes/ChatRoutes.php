<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\ChatController;
use Cursotopia\Middlewares\AuthWebMiddleware;

$app->get("/chat", [ ChatController::class, "chat" ], [ 
    [ AuthWebMiddleware::class ] 
]);

// TODO: Raro
$app->post("/api/v1/chats/find", [ ChatController::class, "getChatByParticipants" ]);
