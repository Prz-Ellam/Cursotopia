<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Max;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Image;
use Cursotopia\Repositories\ImageRepository;
use Cursotopia\ValueObjects\EntityState;
use Exception;

class ImageModel {
    private ?int $id;

    #[Required("El nombre de la imagen es requerido")]
    private ?string $name;

    #[Required("El tamaño de la imagen es requerido")]
    #[Max(8 * 1024 * 1024, "El tamaño de la imagen es muy grande")]
    private ?int $size;

    #[Required("El tipo de la imagen es requerido")]
    #[Enum([ "image/jpg", "image/jpeg", "image/png" ], "El tipo de imagen no es válido")]
    private ?string $contentType;

    #[Required("El contenido de la imagen es requerido")]
    private ?string $data;

    private ?string $createdAt;
    private ?string $modifiedAt;

    private ?bool $active;

    private ImageRepository $imageRepository;
    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->size = $object["size"] ?? null;
        $this->contentType = $object["contentType"] ?? null;
        $this->data = $object["data"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
        
        $this->imageRepository = new ImageRepository();
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
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

    public function getData(): ?string {
        return $this->data;
    }

    public function setData(?string $data): self {
        $this->data = $data;
        return $this;
    }

    public function getModifiedAt(): ?string {
        return $this->modifiedAt;
    }

    public function save(): bool {
        $image = new Image();
        $image
            ->setId($this->id)
            ->setName($this->name)
            ->setSize($this->size)
            ->setContentType($this->contentType)
            ->setData($this->data)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
    
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $this->imageRepository->create($image);
                if ($rowsAffected) {
                    $this->id = intval($this->imageRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $this->imageRepository->update($image);
                break;
            }
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

    public static function findById(?int $id): ?ImageModel {
        $repository = new ImageRepository();
        $object = $repository->findById($id);
        if (!$object) {
            return null;
        }
        return new ImageModel($object);
    }

    public static function findObjById(?int $id): ?array {
        $repository = new ImageRepository();
        return $repository->findById($id);
    }

    public static function findOneByIdAndNotUserId(int $id): ?array {
        $repository = new ImageRepository();
        return $repository->findOneByIdAndNotUserId($id);
    }

    public function toObject(): array {
        $members = get_object_vars($this);
        $members["data"] = base64_encode($members["data"]);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}
