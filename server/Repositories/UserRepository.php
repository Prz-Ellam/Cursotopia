<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\UserRepositoryInterface;
use Cursotopia\Entities\User;

class UserRepository extends DB implements UserRepositoryInterface {
    private const FIND_ONE_ = <<<'SQL'
        SELECT
            `user_id`,
            `user_name`,
            `user_last_name`,
            `user_birth_date`,
            `user_gender`,
            `user_email`,
            `user_password`,
            `user_role`,
            `profile_picture`,
            `user_enabled`,
            `user_created_at`,
            `user_modified_at`,
            `user_active`
        FROM
            `users`
        WHERE
                `user_id` :op_id IFNULL(:id, `user_id`)
            AND `user_name` :op_name IFNULL(:name, `user_name`)
            AND `user_last_name` :op_last_name IFNULL(:last_name, `user_last_name`)
            AND `user_birth_date` :op_birth_date IFNULL(:birth_date, `user_birth_date`)
            AND `user_gender` :op_gender IFNULL(:gender, `user_gender`)
            AND `user_email` :op_email IFNULL(:email, `user_email`)
            AND `user_password` :op_password IFNULL(:password, `user_password`)
            AND `user_role` :op_user_role IFNULL(:user_role, `user_role`)
            AND `profile_picture` :op_profile_picture IFNULL(:profile_picture, `profile_picture`)
            AND `user_enabled` :op_enabled IFNULL(:enabled, `user_enabled`)
            AND `user_created_at` :op_created_at IFNULL(:created_at, `user_created_at`)
            AND `user_modified_at` :op_modified_at IFNULL(:modified_at, `user_modified_at`)
            AND `user_active` :op_active IFNULL(:active, `user_active`)
    SQL;
    
    private const FIND_ONE = <<<'SQL'
        SELECT 
            user_id AS `id`, 
            user_name AS `name`, 
            user_last_name AS `lastName`, 
            user_birth_date AS `birthDate`, 
            user_gender AS `gender`, 
            user_email AS `email`, 
            user_role AS `userRole`, 
            profile_picture AS `profilePicture`
        FROM 
            users 
        WHERE
            user_id = :id
        LIMIT
            1
    SQL;

    private const FIND_ONE_2 = <<<'SQL'
        CALL `find_users`(:id, :id_opt, :email, :email_opt);
    SQL;

    private const FIND_ONE_BY_EMAIL = <<<'SQL'
        SELECT 
            user_id AS `id`, 
            user_name AS `name`, 
            user_last_name AS `lastName`, 
            user_birth_date AS `birthDate`, 
            user_gender AS `gender`, 
            user_email AS `email`, 
            user_role AS `userRole`, 
            user_password AS `password`,
            profile_picture AS `profilePicture`
        FROM 
            users 
        WHERE
            user_email = :email
            AND user_id <> :id
        LIMIT
            1
    SQL;
    
    private const CREATE = <<<'SQL'
        INSERT INTO users(
            user_name, 
            user_last_name, 
            user_birth_date,
            user_gender,
            user_email,
            user_password,
            user_role,
            profile_picture
        ) 
        VALUES(
            :name,
            :last_name,
            :birth_date,
            :gender,
            :email,
            :password,
            :user_role,
            :profile_picture
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL update_user(
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
            user_role AS `userRole`,
            profile_picture AS `profilePicture`
        FROM
            users
        WHERE
            (user_name LIKE CONCAT("%", :name, "%")
            OR user_last_name LIKE CONCAT("%", :name, "%"))
            AND user_role <> :role
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
            "enabled" => null,
            "created_at" => null, 
            "modified_at" => null, 
            "active" => null
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete() {
        
    }

    public function findOne(int $id) {
        return $this::executeOneReader($this::FIND_ONE, [ "id" => $id ]) ?? null;
    }

    public function findOne2(array $parameters) {
        return $this::executeOneReader($this::FIND_ONE_2, $parameters) ?? null;
    }

    public function findOneByEmailAndNotUserId(string $email, int $id) {
        return $this::executeReader($this::FIND_ONE_BY_EMAIL, [ 
            "email" => $email ,
            "id" => $id
        ]) ?? null;
    }

    public function findOneByEmail(string $email) {
        return $this::executeOneReader($this::FIND_ONE_BY_EMAIL, [ 
            "email" => $email ,
            "id" => -1
        ]) ?? null;
    }

    public function findAll(string $name, int $role) {
        $parameters = [
            "name" => $name,
            "role" => $role
        ];
        return $this::executeReader($this::FIND_ALL, $parameters);
    }
}
