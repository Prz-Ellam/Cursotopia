<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\ChatModel;
use Cursotopia\Models\UserModel;

class ChatController {
    public function chat(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        
        $chats = ChatModel::findAllByUser($userId);
        if (!is_array($chats)) {
            $chats = [];
        }
        
        $response->render("chat", [
            "chats" => $chats
        ]); 
    }

    public function getChatByParticipants(Request $request, Response $response): void {
        //$userOne = $request->getBody("userOne");
        $userOne = intval($request->getSession()->get("id"));
        $userTwo = $request->getBody("userTwo");

        $user = UserModel::findById($userTwo);
        if (!$user) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Usuario no encontrado"
            ]);
            return;
        }

        $chat = ChatModel::findOneByUsers($userOne, $userTwo);

        $response->json([
            "chatId" => $chat["chatId"],
            "user" => $user->toArray()
        ]);
    }

    public function getUserChats(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");
        
        $chats = ChatModel::findAllByUser($id);

        if (!is_array($chats)) {
            $chats = [];
        }

        $response->render("/components/chat-drawer", [
            "chats" => $chats
        ]);
    }
}
