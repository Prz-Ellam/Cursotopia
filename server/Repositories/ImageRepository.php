<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Image;
use PDO;

class ImageRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `image_create`(
            :name, 
            :size, 
            :content_type, 
            :data,
            @image_id
        )
    SQL;
    
    private const UPDATE = <<<'SQL'
        CALL `image_update`(
            :id, 
            :name, 
            :size, 
            :content_type, 
            :data, 
            :created_at, 
            :modified_at, 
            :active
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `image_find_by_id`(:id)
    SQL;

    private const FIND_ONE_PROFILE_PICTURE = <<<'SQL'
        CALL `image_find_one_profile_picture`(:id)
    SQL;

    public function create(Image $image): int {
        $parameters = [
            "name" => $image->getName(),
            "size" => $image->getSize(),
            "content_type" => $image->getContentType(),
            "data" => $image->getData()
        ];
        $types = [
            "name" => PDO::PARAM_STR,
            "size" => PDO::PARAM_INT,
            "content_type" => PDO::PARAM_STR,
            "data" => PDO::PARAM_LOB,
        ];
        return $this::executeNonQuery($this::CREATE, $parameters, $types);
    }

    public function update(Image $image): int {
        $parameters = [
            "id" => $image->getId(),
            "name" => $image->getName(),
            "size" => $image->getSize(),
            "content_type" => $image->getContentType(),
            "data" => $image->getData(),
            "created_at" => $image->getCreatedAt(),
            "modified_at" => $image->getModifiedAt(),
            "active" => $image->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function findOneByIdAndNotUserId(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE_PROFILE_PICTURE, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @image_id AS imageId", [])["imageId"];
    }
}
