<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\MessageModel;
use Cursotopia\Repositories\MessageRepository;
use Cursotopia\Repositories\MessageViewRepository;

class MessageController {
    public function getAllByChat(Request $request, Response $response): void {
        $chatId = $request->getParams("chatId");
        $userId = $request->getSession()->get("id");

        $messageRepository = new MessageRepository();
        $messages = $messageRepository->findAllByChat($chatId);

        if (!is_array($messages)) {
            $messages = [];
        }

        $messageViewRepository = new MessageViewRepository();
        $messageViewRepository->viewChat($chatId, $userId);

        $response->json([
            "messages" => $messages,
            "userId" => $userId
        ]);
    }

    public function create(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $chatId = $request->getParams("chatId");
        [
            "content" => $content
        ] = $request->getBody();

        $chat = new MessageModel([
            "content" => $content,
            "userId" => $userId,
            "chatId" => $chatId
        ]);

        $isCreated = $chat->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El mensaje no se pudo crear"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "El mensaje fue creado éxitosamente"
        ]);
    }
}
