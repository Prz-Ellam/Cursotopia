<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\CategoryRepositoryInterface;
use Cursotopia\Entities\Category;

class CategoryRepository implements CategoryRepositoryInterface {
    private const CREATE = <<<'SQL'
        INSERT INTO categories(
            category_name,
            category_description,
            category_created_by
        )
        SELECT
            :name,
            :description,
            :created_by
        FROM
            DUAL
        WHERE
            :name IS NOT NULL
            AND :description IS NOT NULL
            AND :created_by IS NOT NULL
    SQL;

    private const UPDATE = <<<'SQL'
        UPDATE
            categories
        SET
            category_name =         IFNULL(:name, category_name),
            category_description =  IFNULL(:description, category_description),
            category_approved =     IFNULL(:approved, category_approved),
            category_approved_by =  IFNULL(:approved_by, category_approved_by),
            category_modified_at =  NOW(),
            category_active =       IFNULL(:active, category_active)
        WHERE
            category_id = :id
    SQL;

    private const DELETE = <<<'SQL'
        UPDATE
            categories
        SET
            category_modified_at = NOW(),
            category_active = :active
        WHERE
            id = :id
    SQL;

    private const FIND_ONE = <<<'SQL'
        SELECT
            category_id AS `id`,
            category_name AS `name`,
            category_description AS `description`,
            category_approved AS `approved`,
            category_approved_by AS `approvedBy`,
            category_created_by AS `createdBy`,
            category_created_at AS `createdAt`,
            category_modified_at AS `modifiedAt`,
            category_active AS `active`
        FROM
            categories
        WHERE
            category_id = :id
        LIMIT
            1
    SQL;

    private const FIND_ALL = <<<'SQL'
        SELECT
            category_id AS `id`,
            category_name AS `name`,
            category_description AS `description`,
            category_approved AS `approved`,
            category_approved_by AS `approvedBy`,
            category_created_by AS `createdBy`,
            category_created_at AS `createdAt`,
            category_modified_at AS `modifiedAt`,
            category_active AS `active`
        FROM
            categories
        WHERE
            category_active = TRUE
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        SELECT
            c.category_id AS `id`,
            c.category_name AS `name`,
            c.category_description AS `description`,
            c.category_approved AS `approved`,
            c.category_approved_by AS `approvedBy`,
            c.category_created_at AS `createdAt`,
            c.category_modified_at AS `modifiedAt`,
            c.category_active AS `active`
        FROM
            categories AS c
        INNER JOIN
            course_category AS cc
        ON
            c.category_id = cc.category_id
        WHERE
            cc.course_id = :course_id;
    SQL;
    
    public function create(Category $category): int|string {
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
            "approved" => $category->getApproved(),
            "approved_by" => $category->getApprovedBy(),
            "active" => $category->getActive()
        ];
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete(int $id): int {
        $parameters = [
            "id" => $id
        ];
        return DB::executeNonQuery($this::DELETE, $parameters);
    }

    public function findOne(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE, $parameters);
    }

    public function findAll(): array {
        return DB::executeReader($this::FIND_ALL, []);
    }

    public function findAllByCourse(int $courseId): array {
        $parameters = [
            "course_id" => $courseId
        ];
        return DB::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }
}
