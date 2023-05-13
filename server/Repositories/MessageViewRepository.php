<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class MessageViewRepository extends DB implements Repository {
    private const VIEW_CHAT = <<<'SQL'
        CALL `message_view_chat`(:user_id, :chat_id)
    SQL;

    public function viewChat(?int $chatId, ?int $userId): int {
        $parameters = [
            "user_id" => $userId,
            "chat_id" => $chatId
        ];
        return $this::executeNonQuery($this::VIEW_CHAT, $parameters);
    }
}
