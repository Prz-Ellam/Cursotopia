<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\UserModel;
use Cursotopia\Repositories\ChatRepository;

class ChatController {
    public function chat(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
        
        $chatRepository = new ChatRepository();
        $chats = $chatRepository->findAllByUserId($id);
        
        $response->render("chat", [
            "chats" => $chats
        ]); 
    }

    public function getOne(Request $request, Response $response): void {

    }

    public function getChatByParticipants(Request $request, Response $response): void {
        //$userOne = $request->getBody("userOne");
        $userTwo = $request->getBody("userTwo");
        $session = $request->getSession();
        $id = $session->get("id");

        $chatRepository = new ChatRepository();
        $chat = $chatRepository->findChat($id, $userTwo);

        $user = UserModel::findById($userTwo);

        $response->json([
            "chatId" => $chat["chatId"],
            "user" => $user->toObject()
        ]);
    }
}
