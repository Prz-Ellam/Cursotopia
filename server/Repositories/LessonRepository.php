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

    public function findOne(int $id): array {
        return [];
    }
}
