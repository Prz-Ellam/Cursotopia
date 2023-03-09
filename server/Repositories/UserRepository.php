<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\UserRepositoryInterface;
use Cursotopia\Entities\User;

class UserRepository extends DB implements UserRepositoryInterface {
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
}
