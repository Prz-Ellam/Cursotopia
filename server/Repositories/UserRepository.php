<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\UserRepositoryInterface;
use Cursotopia\Entities\User;

class UserRepository extends DB implements UserRepositoryInterface {
    private const CREATE = "
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
        )";
    
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

    public function update() {

    }

    public function delete() {
        
    }
}
