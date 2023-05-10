<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Category;

class CategoryRepository {
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

    private const FIND_ONE = <<<'SQL'
        CALL `category_find_by_id`(:id)
    SQL;

    private const FIND_ALL = <<<'SQL'
        CALL `category_find_all`()
    SQL;

    private const FIND_NOT_ACTIVE = <<<'SQL'
        SELECT
            c.`category_id` AS `id`,
            c.`category_name` AS `name`,
            c.`category_description` AS `description`,
            c.`category_is_approved` AS `isApproved`,
            c.`category_approved_by` AS `approvedBy`,
            c.`category_created_by` AS `createdBy`,
            c.`category_created_at` AS `createdAt`,
            c.`category_modified_at` AS `modifiedAt`,
            c.`category_active` AS `active`,
            CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
        FROM
            `categories` AS c
        INNER JOIN
            `users` AS u
        ON
            c.`category_created_by` = u.`user_id`
        WHERE
            category_active = FALSE;
    SQL;

    private const FIND_ALL_WITH_USER = <<<'SQL'
        SELECT
            `category_id` AS `id`,
            `category_name` AS `name`,
            `category_description` AS `description`,
            `category_is_approved` AS `approved`,
            `category_approved_by` AS `approvedBy`,
            `category_created_by` AS `createdBy`,
            `category_created_at` AS `createdAt`,
            `category_modified_at` AS `modifiedAt`,
            `category_active` AS `active`
        FROM
            `categories`
        WHERE
            `category_active` = TRUE
            AND (`category_is_approved` = TRUE
            OR `category_created_by` = :user_id)
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        SELECT
            c.category_id AS `id`,
            c.category_name AS `name`,
            c.category_description AS `description`,
            c.category_is_approved AS `approved`,
            c.category_approved_by AS `approvedBy`,
            c.category_created_at AS `createdAt`,
            c.category_modified_at AS `modifiedAt`,
            c.category_active AS `active`
        FROM
            categories AS c
        INNER JOIN
            course_category AS cc
        ON
            c.category_id = cc.category_id AND cc.course_category_active = TRUE
        WHERE
            cc.course_id = :course_id;
    SQL;

    private const FIND_NOT_APPROVED = <<<'SQL'
        CALL `category_find_not_approved`()
    SQL;

    private const APPROVE = <<<'SQL'
        CALL `category_approve`(:category_id, :admin_id)
    SQL;

    private const FIND_ONE_BY_NAME = <<<'SQL'
        CALL `category_find_one_by_name`(:name)
    SQL;
    
    public function create(Category $category): int {
        $parameters = [
            "name" => $category->getName(),
            "description" => $category->getDescription(),
            "created_by" => $category->getCreatedBy()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
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
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete(?int $id): int {
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
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE, $parameters);
    }

    public function findAll(): array {
        return DB::executeReader($this::FIND_ALL, []);
    }

    public function findAllWithUser(int $userId): array {
        $parameters = [
            "user_id" => $userId
        ];
        return DB::executeReader($this::FIND_ALL_WITH_USER, $parameters);
    }

    public function findAllByCourse(int $courseId): array {
        $parameters = [
            "course_id" => $courseId
        ];
        return DB::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }

    public function findNotApproved(): array {
        return DB::executeReader($this::FIND_NOT_APPROVED, []);
    }

    public function findNotActive(): array {
        return DB::executeReader($this::FIND_NOT_ACTIVE, []);
    }

    public function approve(int $categoryId, int $adminId): bool {
        $parameters = [
            "category_id" => $categoryId,
            "admin_id" => $adminId
        ];
        return DB::executeNonQuery($this::APPROVE, $parameters);
    }

    public function deny(int $id): bool {
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
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function activate(int $id): bool {
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
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function deactivate(int $id): bool {
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
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findOneByName(?string $name): ?array {
        $parameters = [
            "name" => $name
        ];
        return DB::executeOneReader($this::FIND_ONE_BY_NAME, $parameters);
    }
}
