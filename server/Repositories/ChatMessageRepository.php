<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\ChatMessage;
use Cursotopia\Entities\Message;

class ChatMessageRepository {
    private const CREATE = <<<'SQL'
        INSERT INTO messages(
            message_content,
            user_id,
            chat_id
        )
        VALUES(
            :content,
            :user_id,
            :chat_id
        )
    SQL;

    private const FIND_ALL_BY_CHAT_ID = <<<'SQL'
        SELECT
            m.message_id AS `id`,
            m.message_content AS `content`,
            m.user_id AS `userId`,
            m.chat_id AS `chatId`,
            m.message_created_at AS `createdAt`,
            m.message_modified_at AS `modifiedAt`,
            m.message_active AS `active`,
            mv.viewed_at AS `viewedAt`
        FROM
            messages AS m
        LEFT JOIN
            message_views AS mv
        ON
            m.message_id = mv.message_id
        WHERE
            chat_id = :chat_id
    SQL;

    private const GET_UNREAD_MESSAGES = <<<'SQL'
        SELECT 
            COUNT(DISTINCT m.message_id) AS unread_messages
        FROM 
            messages AS m
        INNER JOIN 
            chats AS c 
        ON
            c.chat_id = m.chat_id
        INNER JOIN 
            chat_participants AS cp 
        ON
            cp.chat_id = c.chat_id
        LEFT JOIN 
            message_views AS v 
        ON
            v.message_id = m.message_id 
            AND v.user_id = :user_id
        WHERE 
            cp.user_id = :user_id
            AND m.message_active = TRUE
            AND v.message_view_id IS NULL 
            AND m.user_id <> :user_id
    SQL;

    public function create(Message $chatMessage): int {
        $parameters = [
            "content" => $chatMessage->getContent(),
            "user_id" => $chatMessage->getUserId(),
            "chat_id" => $chatMessage->getChatId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }

    public function findAllByChat(?int $chatId): ?array {
        $parameters = [
            "chat_id" => $chatId
        ];
        return DB::executeReader($this::FIND_ALL_BY_CHAT_ID, $parameters);
    }

    public function getUnreadMessages(?int $userId): ?array {
        $parameters = [
            "user_id" => $userId
        ];
        return DB::executeOneReader($this::GET_UNREAD_MESSAGES, $parameters);
    }
}
