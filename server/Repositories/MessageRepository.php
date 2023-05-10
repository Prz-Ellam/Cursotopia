<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Message;

class MessageRepository extends DB {
    private const CREATE = <<<'SQL'
        CALL `message_create`(
            :content,
            :user_id,
            :chat_id,
            @message_id
        )
    SQL;

    private const FIND_ALL_BY_CHAT_ID = <<<'SQL'
        CALL `message_find_all_by_chat`(:chat_id)
    SQL;

    private const FIND_UNREAD_MESSAGES = <<<'SQL'
        CALL `message_find_unread_messages`(:user_id)
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
        return DB::executeOneReader($this::FIND_UNREAD_MESSAGES, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @image_id AS imageId", [])["imageId"];
    }
}
