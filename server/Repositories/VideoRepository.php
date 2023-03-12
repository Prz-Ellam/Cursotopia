<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Video;

class VideoRepository extends DB {
    private const FIND_ONE = <<<'SQL'
        SELECT
            video_id AS `id`,
            video_name AS `name`,
            video_duration AS `duration`,
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
            video_address
        )
        SELECT
            :name,
            :duration,
            :address
        FROM
            dual
        WHERE
            :name IS NOT NULL
            AND :duration IS NOT NULL
            AND :address IS NOT NULL
    SQL;
    private const UPDATE = "";

    public function create(Video $video): int {
        $parameters = [
            "name" => $video->getName(),
            "duration" => $video->getDuration(),
            "address" => $video->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function findOne(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE, $parameters);
    }
}
