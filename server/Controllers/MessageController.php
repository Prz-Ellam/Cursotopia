<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Message;
use Cursotopia\Repositories\ChatMessageRepository;
use Cursotopia\Repositories\MessageViewRepository;

class MessageController {
    public function getAllByChat(Request $request, Response $response): void {
        $chatId = $request->getParams("chatId");
        $userId = $request->getSession()->get("id");

        $chatMessageRepository = new ChatMessageRepository();
        $messages = $chatMessageRepository->findAllByChat($chatId);

        $messageViewRepository = new MessageViewRepository();
        $messageViewRepository->viewChat($chatId, $userId);

        $response->json([
            "messages" => $messages,
            "userId" => $userId
        ]);
    }

    public function create(Request $request, Response $response): void {
        $session = $request->getSession();
        $userId = $session->get("id");

        $chatId = $request->getParams("chatId");
        $content = $request->getBody("content");

        $chatMessage = new Message();
        $chatMessage
            ->setContent($content)
            ->setUserId($userId)
            ->setChatId($chatId);

        $chatMessageRepository = new ChatMessageRepository();
        $rowsAffected = $chatMessageRepository->create($chatMessage);

        $response->json($rowsAffected);
    }
}
