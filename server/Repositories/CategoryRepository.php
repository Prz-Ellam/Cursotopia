<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Category;

class CategoryRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `category_create`(
            :name, 
            :description, 
            :created_by, 
            @category_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `category_update`(
            :id,
            :name,
            :description,
            :approved,
            :approved_by,
            :created_by,
            :created_at,
            :modified_at,
            :active
        )
    SQL;

    private const DELETE = <<<'SQL'
        CALL `category_update`(
            :id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, TRUE
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `category_find_by_id`(:id)
    SQL;

    private const FIND_ALL = <<<'SQL'
        CALL `category_find_all`()
    SQL;

    private const FIND_ALL_BY_USER = <<<'SQL'
        CALL `category_find_all_by_user`(:user_id)
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        CALL `category_find_all_by_course`(:course_id)
    SQL;

    private const FIND_ALL_NOT_ACTIVE = <<<'SQL'
        CALL `category_find_all_not_active`()
    SQL;

    private const FIND_ALL_NOT_APPROVED = <<<'SQL'
        CALL `category_find_all_not_approved`()
    SQL;

    private const FIND_ONE_BY_NAME = <<<'SQL'
        CALL `category_find_one_by_name`(:name, :id)
    SQL;
    
    public function create(Category $category): int {
        $parameters = [
            "name" => $category->getName(),
            "description" => $category->getDescription(),
            "created_by" => $category->getCreatedBy()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }
    
    public function update(Category $category): int {
        $parameters = [
            "id" => $category->getId(),
            "name" => $category->getName(),
            "description" => $category->getDescription(),
            "approved" => $category->isApproved(),
            "approved_by" => $category->getApprovedBy(),
            "created_by" => $category->getCreatedBy(),
            "created_at" => $category->getCreatedAt(),
            "modified_at" => $category->getModifiedAt(),
            "active" => $category->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete(?int $id): int {
        $parameters = [
            "id" => $id
        ];
        return $this::executeNonQuery($this::DELETE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    // TODO
    public function findByIdNotApproved(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);      
    }

    public function findAll(): ?array {
        return $this::executeReader($this::FIND_ALL, []);
    }

    public function findAllWithUser(int $userId): ?array {
        $parameters = [
            "user_id" => $userId
        ];
        return $this::executeReader($this::FIND_ALL_BY_USER, $parameters);
    }

    public function findAllByCourse(int $courseId): ?array {
        $parameters = [
            "course_id" => $courseId
        ];
        return $this::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }

    public function findNotApproved(): ?array {
        return $this::executeReader($this::FIND_ALL_NOT_APPROVED, []);
    }

    public function findNotActive(): ?array {
        return $this::executeReader($this::FIND_ALL_NOT_ACTIVE, []);
    }

    public function activate(?int $id): int {
        $parameters = [
            "id" => $id,
            "name" => null,
            "description" => null,
            "approved" => null,
            "approved_by" => null,
            "created_by" => null,
            "created_at" => null,
            "modified_at" => null,
            "active" => true
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function deactivate(?int $id): int {
        $parameters = [
            "id" => $id,
            "name" => null,
            "description" => null,
            "approved" => null,
            "approved_by" => null,
            "created_by" => null,
            "created_at" => null,
            "modified_at" => null,
            "active" => false
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findOneByName(?string $name, ?int $id = -1): ?array {
        $parameters = [
            "name" => $name,
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_NAME, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @category_id AS categoryId", [])["categoryId"];
    }
}
