<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Image;
use Cursotopia\Repositories\ImageRepository;
use Exception;

class ImageModel {
    private int $id;

    #[Required]
    private string $name;

    #[Required]
    private int $size;

    #[Required]
    private string $contentType;

    #[Required]
    private mixed $data;

    private ImageRepository $imageRepository;

    public function __construct() {
        $this->imageRepository = new ImageRepository();
    }

    public function getId(): int {
        return $this->id;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function setSize(int $size): self {
        $this->size = $size;
        return $this;
    }

    public function setContentType(string $contentType): self {
        $this->contentType = $contentType;
        return $this;
    }

    public function setData(mixed $data): self {
        $this->data = $data;
        return $this;
    }

    public function save(): bool {
        try {
            $image = new Image();
            $image
                ->setName($this->name)
                ->setContentType($this->contentType)
                ->setSize($this->size)
                ->setData($this->data);

            $rowsAffected = $this->imageRepository->create($image);
            if ($rowsAffected) {
                $this->id = intval(DB::lastInsertId());
            }
            return ($rowsAffected > 0) ? true : false;
        }
        catch (Exception $exception) {
            // Error con el SQL
            return false;
        }
    }
}
