<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Video;

class VideoRepository extends DB {
    private const FIND_ONE = <<<'SQL'
        SELECT
            video_id AS `id`,
            video_name AS `name`,
            TIME_TO_SEC(video_duration) AS `duration`,
            video_content_type AS `content_type`,
            video_address AS `address`,
            video_created_at AS `createdAt`,
            video_modified_at AS `modifiedAt`,
            video_active AS `active`
        FROM
            videos
        WHERE
            video_id = :id
        LIMIT
            1;
    SQL;

    private const CREATE = <<<'SQL'
        INSERT INTO videos(
            video_name,
            video_duration,
            video_content_type,
            video_address
        )
        VALUES(
            :name,
            :duration,
            :content_type,
            :address
        )
    SQL;
    private const UPDATE = "";

    public function create(Video $video): int {
        $parameters = [
            "name" => $video->getName(),
            "duration" => $video->getDuration(),
            "content_type" => $video->getContentType(),
            "address" => $video->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE, $parameters);
    }
}
