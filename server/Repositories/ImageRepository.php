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

    private const CREATE = "INSERT INTO images(image_name, image_size, image_content_type, image_data) 
        VALUES(:name, :size, :content_type, :data)";
    private const UPDATE = "CALL update_image(?, ?, ?, ?, ?, ?, ?, ?)";

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
}
