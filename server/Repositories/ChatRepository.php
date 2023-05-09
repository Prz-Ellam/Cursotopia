<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class ChatRepository {
    private const CREATE = <<<'SQL'
        INSERT INTO chats VALUES();
    SQL;

    private const FIND_CHAT = <<<'SQL'
        CALL `find_chat`(:user_one, :user_two);
    SQL;

    private const FIND_ALL_BY_USER_ID = <<<'SQL'
        SELECT
            c.chat_id AS `id`, 
            cp.user_id AS `userId`,
            CONCAT(u.user_name, ' ', u.user_last_name) AS `user`,
            u.profile_picture AS `profilePicture`,
            (
                SELECT 
                    COUNT(*) 
                FROM 
                    messages m 
                WHERE 
                    m.chat_id = c.chat_id 
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
            ) AS `unseenMessagesCount`,
            (
                SELECT message_content
                FROM messages m2
                WHERE m2.chat_id = c.chat_id
                ORDER BY message_created_at DESC
                LIMIT 1
            ) AS `lastMessageContent`,
            (
                SELECT 
                    m.message_created_at 
                FROM 
                    messages m 
                WHERE 
                    m.chat_id = c.chat_id 
                ORDER BY 
                    m.message_created_at DESC 
                LIMIT 
                    1
            ) AS `lastMessageCreatedAt`
        FROM 
            chats AS c 
        INNER JOIN 
            chat_participants AS cp ON c.chat_id = cp.chat_id
        INNER JOIN 
            users AS u ON cp.user_id = u.user_id
        WHERE
            c.chat_id IN (
                SELECT 
                    chat_id 
                FROM 
                    chat_participants 
                WHERE 
                    user_id = :user_id
            )
            AND cp.user_id != :user_id
        ORDER BY
            `lastMessageCreatedAt` DESC;
    SQL;

    public function create() {
        DB::executeNonQuery($this::CREATE, []);
    }

    public function findChat(int $userOne, int $userTwo): array {
        $parameters = [
            "user_one" => $userOne,
            "user_two" => $userTwo
        ];
        return DB::executeOneReader($this::FIND_CHAT, $parameters);
    }

    public function findAllByUserId(?int $userId): ?array {
        $parameters = [
            "user_id" => $userId
        ];
        return DB::executeReader($this::FIND_ALL_BY_USER_ID, $parameters);
    }
}
