<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\User;
use PDO;

class UserRepository extends DB {
    private const FIND_BY_ID = <<<'SQL'
        CALL `user_find_by_id`(:id)
    SQL;

    private const FIND_ONE_2 = <<<'SQL'
        CALL `user_find`(:id, :id_opt, :email, :email_opt);
    SQL;

    private const FIND_ONE_BY_EMAIL = <<<'SQL'
        CALL `user_find_one_by_email`(:email)
    SQL;

    private const FIND_ONE_BY_EMAIL_AND_NOT_USER_ID = <<<'SQL'
        SELECT 
            `user_id` AS `id`, 
            `user_name` AS `name`, 
            `user_last_name` AS `lastName`, 
            `user_birth_date` AS `birthDate`, 
            `user_gender` AS `gender`, 
            `user_email` AS `email`, 
            `user_password` AS `password`,
            `user_role` AS `role`, 
            `profile_picture` AS `profilePicture`,
            `user_enabled` AS `enabled`,
            `user_created_at` AS `createdAt`,
            `user_modified_at` AS `modifiedAt`,
            `user_active` AS `active`
        FROM 
            `users` 
        WHERE
            `user_email` = :email
            AND user_id <> :id
        LIMIT
            1
    SQL;
    
    private const CREATE = <<<'SQL'
        CALL `user_create`(
            :name,
            :last_name,
            :birth_date,
            :gender,
            :email,
            :password,
            :user_role,
            :profile_picture,
            @user_id
        )
    SQL;

    private const ENABLE = <<<'SQL'
        UPDATE
        `users`
        SET
            `user_enabled` = TRUE
        WHERE
            `user_id` = :id;
    SQL;

    private const DISABLE = <<<'SQL'
        UPDATE
        `users`
        SET
            `user_enabled` = FALSE
        WHERE
            `user_id` = :id;
    SQL;

    private const UPDATE = <<<'SQL'
        CALL user_update(
            :id, 
            :name, 
            :last_name, 
            :birth_date, 
            :gender, 
            :email, 
            :password, 
            :user_role, 
            :profile_picture, 
            :enabled, 
            :created_at, 
            :modified_at, 
            :active
        )
    SQL;

    private const FIND_ALL = <<<'SQL'
        SELECT
            user_id AS `id`, 
            user_name AS `name`, 
            user_last_name AS `lastName`, 
            user_birth_date AS `birthDate`, 
            user_gender AS `gender`, 
            user_email AS `email`, 
            user_role AS `role`,
            profile_picture AS `profilePicture`
        FROM
            `users`
        WHERE
            (user_name LIKE CONCAT("%", :name, "%")
            OR user_last_name LIKE CONCAT("%", :name, "%"))
            AND user_role <> :role
    SQL;

    private const FIND_ALL_INSTRUCTORS = <<<'SQL'
        CALL `user_find_all_instructors`(:name)
    SQL;

    private const FIND_BLOCKED = <<<'SQL'
        CALL `user_find_blocked`()
    SQL;

    private const FIND_UNBLOCKED = <<<'SQL'
        CALL `user_find_unblocked`()
    SQL;
    
    public function create(User $user): int {
        $parameters = [
            "name" => $user->getName(),
            "last_name" => $user->getLastName(),
            "birth_date" => $user->getBirthDate(),
            "gender" => $user->getGender(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "user_role" => $user->getUserRole(),
            "profile_picture" => $user->getProfilePicture()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(User $user) {
        $parameters = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "last_name" => $user->getLastName(),
            "birth_date" => $user->getBirthDate(),
            "gender" => $user->getGender(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "user_role" => null,
            "profile_picture" => null,
            "enabled" => $user->getEnabled(),
            "created_at" => null, 
            "modified_at" => null, 
            "active" => null
        ];
        $types = [
            "id" => PDO::PARAM_INT,
            "name" => PDO::PARAM_STR,
            "last_name" => PDO::PARAM_STR,
            "birth_date" => PDO::PARAM_STR,
            "gender" => PDO::PARAM_STR,
            "email" => PDO::PARAM_STR,
            "password" => PDO::PARAM_STR,
            "user_role" => PDO::PARAM_NULL,
            "profile_picture" => PDO::PARAM_NULL,
            "enabled" => PDO::PARAM_BOOL,
            "created_at" => PDO::PARAM_NULL, 
            "modified_at" => PDO::PARAM_NULL, 
            "active" => PDO::PARAM_NULL
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters, $types);
    }

    public function delete() {
        
    }

    public function findOne(?int $id) {
        return $this::executeOneReader($this::FIND_BY_ID, [ "id" => $id ]) ?? null;
    }

    public function findOne2(array $parameters) {
        return $this::executeOneReader($this::FIND_ONE_2, $parameters) ?? null;
    }

    public function findOneByEmailAndNotUserId(string $email, int $id) {
        return $this::executeReader($this::FIND_ONE_BY_EMAIL_AND_NOT_USER_ID, [ 
            "email" => $email ,
            "id" => $id
        ]) ?? null;
    }

    public function findOneByEmail(string $email) {
        $parameters = [
            "email" => $email
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_EMAIL, $parameters);
    }

    public function enable(int $userId) {
        $parameters = [
            "id" => $userId
        ];
        return $this::executeNonQuery($this::ENABLE, $parameters);
    }
    
    public function disable(int $userId) {
        $parameters = [
            "id" => $userId
        ];
        return $this::executeNonQuery($this::DISABLE, $parameters);
    }

    public function findAll(string $name, int $role) {
        $parameters = [
            "name" => $name,
            "role" => $role
        ];
        return $this::executeReader($this::FIND_ALL, $parameters);
    }

    public function findAllInstructors(string $name) {
        $parameters = [
            "name" => $name
        ];
        return $this::executeReader($this::FIND_ALL_INSTRUCTORS, $parameters);
    }

    public function findBlocked() {
        return $this::executeReader($this::FIND_BLOCKED, []);
    }

    public function findUnblocked() {
        return $this::executeReader($this::FIND_UNBLOCKED, []);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @user_id AS userId", [])["userId"];
    }
}
