<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\User;

class UserRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `user_create`(
            :name,
            :last_name,
            :birth_date,
            :gender,
            :email,
            :password,
            :role,
            :profile_picture,
            @user_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `user_update`(
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
        CALL `user_find_one_by_email_and_not_user_id`(:email, :id)
    SQL;
    
    private const FIND_ALL = <<<'SQL'
        CALL `user_find_all`(:name, :role)
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
            "role" => $user->getRole(),
            "profile_picture" => $user->getProfilePicture()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(User $user): int {
        $parameters = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "last_name" => $user->getLastName(),
            "birth_date" => $user->getBirthDate(),
            "gender" => $user->getGender(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "user_role" => null,
            "profile_picture" => $user->getProfilePicture(),
            "enabled" => $user->getEnabled(),
            "created_at" => $user->getCreatedAt(), 
            "modified_at" => $user->getModifiedAt(), 
            "active" => $user->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete() {
        
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function findOne2(array $parameters): ?array {
        return $this::executeOneReader($this::FIND_ONE_2, $parameters) ?? null;
    }

    public function findOneByEmailAndNotUserId(?string $email, ?int $id): ?array {
        $parameters = [
            "email" => $email ,
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_EMAIL_AND_NOT_USER_ID, $parameters);
    }

    public function findOneByEmail(?string $email): ?array {
        $parameters = [
            "email" => $email
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_EMAIL, $parameters);
    }

    public function findAll(?string $name, ?int $role): ?array {
        $parameters = [
            "name" => $name,
            "role" => $role
        ];
        return $this::executeReader($this::FIND_ALL, $parameters);
    }

    public function findAllInstructors(?string $name): ?array {
        $parameters = [
            "name" => $name
        ];
        return $this::executeReader($this::FIND_ALL_INSTRUCTORS, $parameters);
    }

    public function findBlocked(): ?array {
        return $this::executeReader($this::FIND_BLOCKED, []);
    }

    public function findUnblocked(): ?array {
        return $this::executeReader($this::FIND_UNBLOCKED, []);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @user_id AS userId", [])["userId"];
    }
}
