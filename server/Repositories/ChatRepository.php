<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class ChatRepository {
    private const CREATE = <<<'SQL'
        INSERT INTO `chats` VALUES();
    SQL;

    private const FIND_CHAT = <<<'SQL'
        CALL `find_chat`(:user_one, :user_two);
    SQL;

    private const FIND_ALL_BY_USER = <<<'SQL'
        CALL `find_all_by_user`(:user_id)
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
        return DB::executeReader($this::FIND_ALL_BY_USER, $parameters);
    }
}
