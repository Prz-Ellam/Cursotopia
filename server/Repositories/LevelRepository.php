<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Level;

class LevelRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `level_create`(
            :title, 
            :description, 
            :is_free, 
            :course_id, 
            @level_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `level_update`(
            :id, 
            :title, 
            :description, 
            :is_free, 
            NULL, 
            NULL, 
            NULL, 
            :active
        )
    SQL;

    private const DELETE = <<<'SQL'
        CALL `level_update`(
            :id, NULL, NULL, NULL, NULL, NULL, NULL, FALSE
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `level_find_by_id`(:id)
    SQL;

    private const FIND_BY_COURSE = <<<'SQL'
        CALL `level_find_by_course`(:course_id)
    SQL;

    private const FIND_ALL_USER_COMPLETE = <<<'SQL'
        CALL `level_find_user_complete`(:course_id, :user_id)
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        SELECT
            l.`level_id` AS `id`,
            l.`level_title` AS `title`,
            l.`level_description` AS `description`,
            l.`level_is_free` AS `free`,
            l.`course_id` AS `courseId`,
            l.`level_created_at` AS `createdAt`,
            l.`level_modified_at` AS `modifiedAt`,
            l.`level_active` AS `active`,
            CONCAT('[', GROUP_CONCAT(
                JSON_OBJECT(
                    'id', le.`lesson_id`,
                    'title', le.`lesson_title`, 
                    'description', le.`lesson_description`,
                    'mainResource', find_main_resource(le.`lesson_id`),
                    'video_duration', IF(v.`video_duration` >= 3600, v.`video_duration`, RIGHT(v.`video_duration`, 5))
                )
            ), ']') AS `lessons`
        FROM
            `levels` AS l
        INNER JOIN
            `lessons` AS le
        ON
            l.`level_id` = le.`level_id` AND le.`lesson_active` = TRUE
        LEFT JOIN
            `videos` AS v
        ON
            le.`video_id` = v.`video_id`
        WHERE
            l.`course_id` = :course_id
        GROUP BY
            l.`level_id`;
    SQL;

    public function create(Level $level): int {
        $parameters = [
            "title" => $level->getTitle(),
            "description" => $level->getDescription(),
            "is_free" => $level->isFree(),
            "course_id" => $level->getCourseId()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Level $level): int {
        $parameters = [
            "id" => $level->getId(),
            "title" => $level->getTitle(),
            "description" => $level->getDescription(),
            "is_free" => $level->isFree(),
            "active" => $level->isActive()
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

    public function findByCourse(?int $courseId): ?array {
        $parameters = [
            "course_id" => $courseId
        ];
        return $this::executeReader($this::FIND_BY_COURSE, $parameters);
    }

    public function findAllByCourse(?int $courseId): ?array {
        $parameters = [
            "course_id" => $courseId
        ];
        return $this::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }

    public function findAllUserComplete(?int $courseId, ?int $userId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "user_id" => $userId
        ];
        return $this::executeReader($this::FIND_ALL_USER_COMPLETE, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @level_id AS levelId", [])["levelId"];
    }
}