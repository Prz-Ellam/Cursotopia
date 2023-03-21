<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\LessonRepositoryInterface;
use Cursotopia\Entities\Lesson;

class LessonRepository extends DB implements LessonRepositoryInterface {
    private const CREATE = <<<'SQL'
        INSERT INTO lessons(
            lesson_title,
            lesson_description,
            level_id,
            video_id,
            image_id,
            document_id,
            link_id
        )
        SELECT
            :title,
            :description,
            :level_id,
            :video_id,
            :image_id,
            :document_id,
            :link_id
        FROM
            dual
        WHERE
            :title IS NOT NULL
            AND :description IS NOT NULL
            AND :level_id IS NOT NULL
    SQL;

    private const FIND_ONE_BY_ID = <<<'SQL'
        SELECT
            lesson_id AS `id`,
            lesson_title AS `title`,
            lesson_description AS `description`,
            level_id AS `levelId`,
            video_id AS `videoId`,
            image_id AS `imageId`,
            document_id AS `documentId`,
            link_id AS `linkId`,
            lesson_created_at AS `createdAt`,
            lesson_modified_at AS `modifiedAt`,
            lesson_active AS `active`
        FROM
            lessons
        WHERE
            lesson_id = :id
    SQL;

    private const FIND_FIRST_NOT_VIEWED = <<<'SQL'
        SELECT
            le.lesson_id AS `id`,
            le.lesson_title AS `title`,
            ule.user_lesson_is_complete AS `complete`
        FROM
            lessons AS le
        INNER JOIN
            user_lesson AS ule
        ON
            le.lesson_id = ule.lesson_id
        INNER JOIN
            levels AS l
        ON
            le.level_id = l.level_id
        INNER JOIN
            enrollments AS e
        ON
            l.course_id = e.course_id
        WHERE
            e.course_id = :course_id
            AND ule.user_id = :user_id
            AND ule.user_lesson_is_complete = FALSE
        ORDER BY
            le.lesson_created_at ASC
        LIMIT
            1;
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
        return 1;
    }

    public function delete(int $id): int {
        return 1;
    }

    public function findOneById(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE_BY_ID, $parameters);
    }

    public function findFirstNotViewed(int $courseId, int $userId) {
        $parameters = [
            "course_id" => $courseId,
            "user_id" => $userId
        ];
        return DB::executeOneReader($this::FIND_FIRST_NOT_VIEWED, $parameters);
    }
}
