<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Image;

class ImageRepository {
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
        $affectedRows = DB::executeNonQuery($this::CREATE, $parameters);
        return $affectedRows;
    }

    public function update() {
        $affectedRows = DB::executeNonQuery($this::UPDATE, []);
    }

    public function delete() {
        $affectedRows = DB::executeNonQuery($this::UPDATE, []);
    }
}
