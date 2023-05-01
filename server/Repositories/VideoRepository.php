<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Video;

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

    private const FIND_BY_ID = <<<'SQL'
        CALL `video_find_by_id`(:id)
    SQL;

    public function create(Video $video): int {
        $parameters = [
            "name" => $video->getName(),
            "duration" => $video->getDuration(),
            "content_type" => $video->getContentType(),
            "address" => $video->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Video $video): bool {
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
