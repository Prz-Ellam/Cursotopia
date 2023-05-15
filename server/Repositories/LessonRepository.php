<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Lesson;

class LessonRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `lesson_create`(
            :title, 
            :description, 
            :level_id, 
            :video_id, 
            :image_id,
            :document_id, 
            :link_id, 
            @lesson_id
        );
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `lesson_update`(
            :id, 
            :title, 
            :description, 
            :level_id, 
            :video_id, 
            :image_id,
            :document_id, 
            :link_id, 
            :created_at, 
            :modified_at, 
            :active
        )
    SQL;

    private const FIND_ONE_BY_ID = <<<'SQL'
        CALL `lesson_find_by_id`(:id)
    SQL;

    private const COURSE_VISOR_FIND_BY_ID = <<<'SQL'
        SELECT
            `lesson_id` AS `id`,
            `lesson_title` AS `title`,
            `lesson_description` AS `description`,
            `video_id` AS `videoId`,
            `image_id` AS `imageId`,
            `document_id` AS `documentId`,
            `link_id` AS `linkId`,
            `link_name` AS `linkName`,
            `link_address` AS `linkAddress`,
            `resource`,
            `lesson_created_at` AS `createdAt`,
            `lesson_modified_at` AS `modifiedAt`,
            `lesson_active` AS `active`,
            `level_id` AS `levelId`,
            `level_is_free` AS `levelFree`
        FROM
            `course_visor`
        WHERE
            `lesson_id` = :lesson_id
    SQL;

    private const FIND_BY_LEVEL = <<<'SQL'
        CALL `lesson_find_by_level`(:level_id)
    SQL;

    private const FIND_FIRST_NOT_VIEWED = <<<'SQL'
        SELECT
            le.`lesson_id` AS `id`,
            le.`lesson_title` AS `title`,
            ule.`user_lesson_is_complete` AS `complete`
        FROM
            `lessons` AS le
        INNER JOIN
            `user_lesson` AS ule
        ON
            le.`lesson_id` = ule.`lesson_id`
        INNER JOIN
            `levels` AS l
        ON
            le.`level_id` = l.`level_id`
        INNER JOIN
            `enrollments` AS e
        ON
            l.`course_id` = e.`course_id`
        WHERE
            e.`course_id` = :course_id
            AND ule.`user_id` = :user_id
            AND ule.`user_lesson_is_complete` = FALSE
        ORDER BY
            le.`lesson_created_at` ASC
        LIMIT
            1;
    SQL;

    private const FIRST_LESSON_PENDING = <<<'SQL'
        SELECT l.`lesson_id` AS `id` 
        FROM `user_lesson` AS ul
        INNER JOIN `lessons` AS l ON ul.`lesson_id` = l.`lesson_id`
        WHERE ul.`user_id` = :user_id
        AND ul.`user_lesson_is_complete` = FALSE
        AND (
            SELECT `courses`.`course_id`
            FROM `courses`
            JOIN `levels` ON `levels`.`course_id` = `courses`.`course_id`
            JOIN `lessons` ON `lessons`.`level_id` = `levels`.`level_id`
            WHERE `lessons`.`lesson_id` = ul.`lesson_id`
            LIMIT 1
        ) = :course_id
        ORDER BY l.`lesson_created_at` ASC
        LIMIT 1
    SQL;

    private const FIRST_LESSON_COMPLETE = <<<'SQL'
        SELECT l.`lesson_id` AS `id` 
        FROM `user_lesson` AS ul
        INNER JOIN `lessons` AS l ON ul.`lesson_id` = l.`lesson_id`
        WHERE ul.`user_id` = :user_id
        AND ul.`user_lesson_is_complete` = TRUE
        AND (
            SELECT `courses`.`course_id`
            FROM `courses`
            JOIN `levels` ON `levels`.`course_id` = `courses`.`course_id`
            JOIN `lessons` ON `lessons`.`level_id` = `levels`.`level_id`
            WHERE `lessons`.`lesson_id` = ul.`lesson_id`
            LIMIT 1
        ) = :course_id
        ORDER BY l.`lesson_created_at` ASC
        LIMIT 1
    SQL;

    public function create(Lesson $lesson): int {
        $parameters = [
            "title" => $lesson->getTitle(),
            "description" => $lesson->getDescription(),
            "level_id" => $lesson->getLevelId(),
            "video_id" => $lesson->getVideoId(),
            "image_id" => $lesson->getImageId(),
            "document_id" => $lesson->getDocumentId(),
            "link_id" => $lesson->getLinkId()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Lesson $lesson): int {
        $parameters = [
            "id" => $lesson->getId(),
            "title" => $lesson->getTitle(),
            "description" => $lesson->getDescription(),
            "level_id" => $lesson->getLevelId(),
            "video_id" => $lesson->getVideoId(),
            "image_id" => $lesson->getImageId(),
            "document_id" => $lesson->getDocumentId(),
            "link_id" => $lesson->getLinkId(),
            "created_at" => $lesson->getCreatedAt(),
            "modified_at" => $lesson->getModifiedAt(),
            "active" => $lesson->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }
    
    public function delete(int $id): int {
        return 1;
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_ID, $parameters);
    }

    public function findByLevel(?int $levelId): ?array {
        $parameters = [
            "level_id" => $levelId
        ];
        return $this::executeReader($this::FIND_BY_LEVEL, $parameters);
    }

    public function findFirstNotViewed(?int $courseId, ?int $userId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "user_id" => $userId
        ];
        return $this::executeOneReader($this::FIND_FIRST_NOT_VIEWED, $parameters);
    }

    public function firstLessonPending(int $courseId, int $userId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "user_id" => $userId
        ];
        return $this::executeOneReader($this::FIRST_LESSON_PENDING, $parameters);
    }

    public function firstLessonComplete(?int $courseId, ?int $userId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "user_id" => $userId
        ];
        return $this::executeOneReader($this::FIRST_LESSON_COMPLETE, $parameters);
    }

    public function courseVisorFindById(?int $lessonId): ?array {
        $parameters = [
            "lesson_id" => $lessonId
        ];
        return $this::executeOneReader($this::COURSE_VISOR_FIND_BY_ID, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @lesson_id AS lessonId", [])["lessonId"];
    }
}
