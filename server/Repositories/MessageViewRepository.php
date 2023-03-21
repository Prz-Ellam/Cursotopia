<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class MessageViewRepository {
    private const VIEW_CHAT = <<<'SQL'
        INSERT INTO message_views(
            message_id, 
            user_id
        )
        SELECT 
            m.message_id,
            :user_id
        FROM 
            messages m 
        WHERE 
            m.chat_id = :chat_id 
            AND m.user_id != :user_id
            AND NOT EXISTS (
                SELECT 
                    1 
                FROM 
                    message_views mv 
                WHERE 
                    mv.message_id = m.message_id 
                    AND mv.user_id = :user_id
            )
    SQL;

    public function viewChat(int $chatId, int $userId) {
        $parameters = [
            "chat_id" => $chatId,
            "user_id" => $userId
        ];
        DB::executeNonQuery($this::VIEW_CHAT, $parameters);
    }
}
