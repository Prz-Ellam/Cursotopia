<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Image;
use Cursotopia\Repositories\ImageRepository;
use Exception;

class ImageModel {
    private ?int $id;

    #[Required("El nombre de la imagen es requerido")]
    private ?string $name;

    #[Required("El tamaño de la imagen es requerido")]
    private ?int $size;

    #[Required("El tipo de la imagen es requerido")]
    private ?string $contentType;

    #[Required("El contenido de la imagen es requerido")]
    private mixed $data;

    private ?string $createdAt;
    private ?string $modifiedAt;

    private ImageRepository $imageRepository;

    public function __construct(?array $object = null) {
        $this->imageRepository = new ImageRepository();
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->size = $object["size"] ?? null;
        $this->contentType = $object["contentType"] ?? null;
        $this->data = $object["data"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getSize(): ?int {
        return $this->size;
    }

    public function setSize(?int $size): self {
        $this->size = $size;
        return $this;
    }

    public function getContentType(): ?string {
        return $this->contentType;
    }

    public function setContentType(?string $contentType): self {
        $this->contentType = $contentType;
        return $this;
    }

    public function getData(): mixed {
        return $this->data;
    }

    public function setData(mixed $data): self {
        $this->data = $data;
        return $this;
    }

    public function getModifiedAt(): ?string {
        return $this->modifiedAt;
    }

    public function save(): bool {
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

    public function update(): bool {
        $image = new Image();
        $image
            ->setId($this->id)
            ->setName($this->name)
            ->setContentType($this->contentType)
            ->setSize($this->size)
            ->setData($this->data);

        $rowsAffected = $this->imageRepository->update($image);
        return ($rowsAffected > 0) ? true : false;
}

    public static function findOneById(int $id): ?ImageModel {
        $repository = new ImageRepository();
        $object = $repository->findOneById($id);
        if (!$object) {
            return null;
        }
        return new ImageModel($object);
    }

    public static function findOneByIdAndNotUserId(int $id): ?array {
        $repository = new ImageRepository();
        return $repository->findOneByIdAndNotUserId($id);
    }
}
