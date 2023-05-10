<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class MessageViewRepository {
    private const VIEW_CHAT = <<<'SQL'
        CALL `message_view_chat`(:user_id, :chat_id)
    SQL;

    public function viewChat(int $chatId, int $userId) {
        $parameters = [
            "user_id" => $userId,
            "chat_id" => $chatId
        ];
        DB::executeNonQuery($this::VIEW_CHAT, $parameters);
    }
}
