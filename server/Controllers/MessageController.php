<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Message;
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
        $content = $request->getBody("content");

        $chatMessage = new Message();
        $chatMessage
            ->setContent($content)
            ->setUserId($userId)
            ->setChatId($chatId);

        $messageRepository = new MessageRepository();
        $rowsAffected = $messageRepository->create($chatMessage);

        $response->json($rowsAffected);
    }
}
