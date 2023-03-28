<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\User;

class AuthRepository {
    private const LOGIN = <<<'SQL'
        SELECT 
            user_id AS `id`, 
            user_password AS `password`,
            user_enabled AS `enabled`,
            user_role AS `userRole`,
            profile_picture AS `profilePicture`
        FROM
            users AS u
        INNER JOIN
            roles AS r
        ON
            u.user_role = r.role_id
        WHERE
            user_email = :email
            AND user_active = TRUE
    SQL;

    public function login(User $user): array {
        $parameters = [
            "email" => $user->getEmail()
        ];
        return DB::executeOneReader($this::LOGIN, $parameters);
    }
}
