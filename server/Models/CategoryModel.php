<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Category;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class CategoryModel implements JsonSerializable {
    private static ?CategoryRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?bool $approved = null;
    private ?int $approvedBy = null;
    private ?int $createdBy = null;
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

    public function save(): bool {
        $category = new Category();
        $category
            ->setId($this->id)
            ->setName($this->name)
            ->setDescription($this->description)
            ->setApproved($this->approved)
            ->setApprovedBy($this->approvedBy)
            ->setCreatedBy($this->createdBy)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($category);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($category);
                break;
            }
        }

        return ($rowsAffected > 0) ? true : false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }
 
    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getCreatedBy(): ?int {
        return $this->createdBy;
    }
 
    public function setCreatedBy(?int $createdBy): self {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getApproved(): ?bool {
        return $this->approved;
    }
 
    public function setApproved(?bool $approved): self {
        $this->approved = $approved;
        return $this;
    }

    public function getApprovedBy(): ?int {
        return $this->approvedBy;
    }

    public function setApprovedBy(?int $approvedBy): self {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public static function findById(?int $id): ?CategoryModel {
        $object = self::$repository->findById($id);
        if (!$object) {
            return null;
        }
        return new CategoryModel($object);
    }

    public static function findOneByName(?string $name, ?int $id = -1): ?CategoryModel {
        $object = self::$repository->findOneByName($name, $id);
        if (!$object) {
            return null;
        }
        return new CategoryModel($object);
    }

    public static function findAll(): ?array {
        return self::$repository->findAll();
    }

    public static function findAllByCourse(?int $courseId): ?array {
        return self::$repository->findAllByCourse($courseId);
    }

    public static function findAllWithUser(int $userId): ?array {
        return self::$repository->findAllWithUser($userId);
    }

    public static function findNotApproved() {
        return self::$repository->findNotApproved();
    }

    public static function findNotActive() {
        return self::$repository->findNotActive();
    }

    

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new CategoryRepository();
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

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }

    public function getActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
    }
}

CategoryModel::init();