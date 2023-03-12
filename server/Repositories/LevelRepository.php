<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\LevelRepositoryInterface;
use Cursotopia\Entities\Level;

class LevelRepository extends DB implements LevelRepositoryInterface {
    private const CREATE = <<<'SQL'
        INSERT INTO levels(
            level_title,
            level_description,
            level_price,
            course_id
        )
        SELECT
            :title,
            :description,
            :price,
            :course_id
        FROM
            dual
        WHERE
            :title IS NOT NULL
            AND :description IS NOT NULL
            AND :price IS NOT NULL
            AND :course_id IS NOT NULL
    SQL;

    private const UPDATE = <<<'SQL'
        UPDATE
            levels
        SET
            level_title = IFNULL(:title, level_title),
            level_description = IFNULL(:description, level_description),
            level_price = IFNULL(:price, level_price),
            level_modified_at = NOW(),
            level_active = IFNULL(:active, level_active)
        WHERE
            level_id = :id
    SQL;

    private const DELETE = <<<'SQL'

    SQL;

    private const FIND_ONE = <<<'SQL'
        SELECT
            level_id AS `id`,
            level_title AS `title`,
            level_description AS `description`,
            level_price AS `price`,
            course_id AS `courseId`,
            level_created_at AS `createdAt`,
            level_modified_at AS `modifiedAt`,
            level_active AS `active`
        FROM
            levels
        WHERE
            level_id = :id
    SQL;

    public function create(Level $level): int {
        $parameters = [
            "title" => $level->getTitle(),
            "description" => $level->getDescription(),
            "price" => $level->getPrice(),
            "course_id" => $level->getCourseId()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Level $level): int {
        $parameters = [
            "id" => $level->getId(),
            "title" => $level->getTitle(),
            "description" => $level->getDescription(),
            "price" => $level->getPrice(),
            "active" => $level->getActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete(int $id): int {
        return 1;
    }

    public function findOne(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE, $parameters);
    }
}