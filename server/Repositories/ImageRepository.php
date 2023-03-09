<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Image;

class ImageRepository extends DB {
    private const FIND_ONE = <<<'SQL'
        SELECT
            `image_id` AS `id`,
            `image_name` AS `name`,
            `image_size` AS `size`,
            `image_content_type` AS `contentType`,
            `image_data` AS `data`,
            `image_created_at` AS `createdAt`,
            `image_modified_at` AS `modifiedAt`,
            `image_active` AS `active`
        FROM
            `images`
        WHERE
            `image_id` = :id
        LIMIT
            1
    SQL;

    private const CREATE = <<<'SQL'
        INSERT INTO images(
            image_name, 
            image_size, 
            image_content_type, 
            image_data
        ) 
        VALUES(
            :name, 
            :size, 
            :content_type, 
            :data
        )
    SQL;

    private const FIND_ONE_BY_ID_AND_NOT_USER_ID = <<<'SQL'
        SELECT
            i.image_id AS `id`,
            i.image_name AS `name`,
            i.image_size AS `size`,
            i.image_content_type AS `contentType`,
            i.image_data AS `data`,
            i.image_created_at AS `createdAt`,
            i.image_modified_at AS `modifiedAt`,
            i.image_active AS `active`
        FROM
            images AS i
        INNER JOIN
            users AS u
        ON
            i.image_id = u.profile_picture
        WHERE
            i.image_id = :id
    SQL;
    
    private const UPDATE = <<<'SQL'
        CALL update_image(?, ?, ?, ?, ?, ?, ?, ?)
    SQL;

    public function create(Image $image): int {
        $parameters = [
            "name" => $image->getName(),
            "size" => $image->getSize(),
            "content_type" => $image->getContentType(),
            "data" => $image->getData()
        ];
        $affectedRows = self::executeNonQuery($this::CREATE, $parameters);
        return $affectedRows;
    }

    public function update() {
        $affectedRows = self::executeNonQuery($this::UPDATE, []);
    }

    public function delete() {
        $affectedRows = self::executeNonQuery($this::UPDATE, []);
    }

    public function findOneById(int $id): ?array {
        return $this::executeOneReader($this::FIND_ONE, [ "id" => $id ]) ?? null;
    }

    public function findOneByIdAndNotUserId(int $id): ?array {
        return $this::executeOneReader($this::FIND_ONE_BY_ID_AND_NOT_USER_ID, [
            "id" => $id
        ]) ?? null;
    }
}
