<?php

namespace Cursotopia\Models;

use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Max;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Image;
use Cursotopia\Repositories\ImageRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class ImageModel implements JsonSerializable {
    private static ?ImageRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;

    #[Required("El nombre de la imagen es requerido")]
    private ?string $name = null;

    #[Required("El tamaño de la imagen es requerido")]
    #[Max(8 * 1024 * 1024, "El tamaño de la imagen es muy grande")]
    private ?int $size = null;

    #[Required("El tipo de la imagen es requerido")]
    #[Enum([ "image/jpg", "image/jpeg", "image/png" ], "El tipo de imagen no es válido")]
    private ?string $contentType = null;

    #[Required("El contenido de la imagen es requerido")]
    private ?string $data = null;

    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public function __construct(?array $data = null) {
        $properties = get_object_vars($this);
        foreach ($properties as $name => $value) {
            if ($value instanceof Repository || $value instanceof EntityState) {
                continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            $this->$name = (isset($data[$name])) ? $data[$name] : null;
        }
        
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

    public function getActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
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
                $rowsAffected = self::$repository->create($image);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($image);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    



    public static function findById(?int $id): ?ImageModel {
        $object = self::$repository->findById($id);
        if (!$object) {
            return null;
        }
        return new ImageModel($object);
    }

    public static function findOneByIdAndNotUserId(int $id): ?array {
        return self::$repository->findOneByIdAndNotUserId($id);
    }



    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new ImageRepository();
        }
    }

    public function toArray(): ?array {
        return json_decode(json_encode($this), true);
    }

    public function jsonSerialize(): mixed {
        $properties = get_object_vars($this);
        $output = [];
        
        foreach ($properties as $name => $value) {
            if (in_array($name, $this->_ignores)) {
                 continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            if (!($value instanceof Repository) && !($value instanceof EntityState)) {
                $output[$name] = $value;
            }
        }
        
        return $output;
    }

    public function setIgnores(array $ignores) {
        $this->_ignores = $ignores;
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

ImageModel::init();