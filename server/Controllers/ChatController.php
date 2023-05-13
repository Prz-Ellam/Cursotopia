<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;
use Cursotopia\Repositories\ChatRepository;

class ChatController {
    public function chat(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");
        
        $chatRepository = new ChatRepository();
        $chats = $chatRepository->findAllByUserId($id);

        if (!is_array($chats)) {
            $chats = [];
        }
        
        $response->render("chat", [
            "chats" => $chats
        ]); 
    }

    public function getChatByParticipants(Request $request, Response $response): void {
        //$userOne = $request->getBody("userOne");
        $userOne = $request->getSession()->get("id");
        $userTwo = $request->getBody("userTwo");

        $chatRepository = new ChatRepository();
        $chat = $chatRepository->findChat($userOne, $userTwo);

        $user = UserModel::findById($userTwo);

        $response->json([
            "chatId" => $chat["chatId"],
            "user" => $user->toArray()
        ]);
    }

    public function getUserChats(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");
        
        $chatRepository = new ChatRepository();
        $chats = $chatRepository->findAllByUserId($id);

        if (!is_array($chats)) {
            $chats = [];
        }

        $response->render("/components/chat-drawer", [
            "chats" => $chats
        ]);
    }
}
