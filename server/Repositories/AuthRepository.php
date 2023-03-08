<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\User;

class AuthRepository {
    private const LOGIN = "
        SELECT 
            user_id AS `id`, 
            user_password AS `password`,
            user_enabled AS `enabled`,
            user_role AS `userRole`,
            profile_picture AS `profilePicture`
        FROM
            users AS u
        INNER JOIN
            user_roles AS ur
        ON
            u.user_role = ur.user_role_id
        WHERE
            user_email = :email
            AND user_active = TRUE
    ";

    public function login(User $user): array {
        $parameters = [
            "email" => $user->getEmail()
        ];
        return DB::executeOneReader($this::LOGIN, $parameters);
    }
}
