<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Video;

/**
 * Repositorio para manejar videos
 */
class VideoRepository extends DB {
    private const CREATE = <<<'SQL'
        CALL `video_create`(
            :name,
            :duration,
            :content_type,
            :address,
            @video_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `video_update`(
            :id,
            :name,
            :duration,
            :content_type,
            :address,
            :created_at,
            :modified_at,
            :active
        )
    SQL;

    private const CHECK_RESOURCE_AVAILABILITY_BY_USER = <<<'SQL'
        SELECT 
            l.level_is_free AS `free`, 
            e.enrollment_is_paid AS `paid`,
            c.course_price AS `price`
        FROM `lessons` AS le
        INNER JOIN `levels` AS l
        ON le.level_id = l.level_id
        INNER JOIN `enrollments` AS e
        ON l.course_id = e.course_id AND e.student_id = :user_id
        INNER JOIN `courses` AS c
        ON e.course_id = c.course_id
        WHERE `video_id` = :video_id  
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `video_find_by_id`(:id)
    SQL;

    public function video(?int $userId, ?int $videoId): ?array {
        $parameters = [
            "user_id" => $userId,
            "video_id" => $videoId
        ];
        return $this::executeOneReader($this::CHECK_RESOURCE_AVAILABILITY_BY_USER, $parameters);
    }

    public function create(Video $video): int {
        $parameters = [
            "name" => $video->getName(),
            "duration" => $video->getDuration(),
            "content_type" => $video->getContentType(),
            "address" => $video->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Video $video): int {
        $parameters = [
            "id" => $video->getId(),
            "name" => $video->getName(),
            "duration" => $video->getDuration(),
            "content_type" => $video->getContentType(),
            "address" => $video->getAddress(),
            "created_at" => $video->getCreatedAt(),
            "modified_at" => $video->getModifiedAt(),
            "active" => $video->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }
    
    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @video_id AS videoId", [])["videoId"];
    }
}
