<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Link;
use Cursotopia\Repositories\LinkRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class LinkModel implements JsonSerializable {
    private static ?LinkRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];
    
    private ?int $id = null;
    private ?string $name = null;
    private ?string $address = null;
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
        $link = new Link();
        $link
            ->setId($this->id)
            ->setName($this->name)
            ->setAddress($this->address)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($link);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($link);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public static function findById(?int $id): ?LinkModel {
        $linkObject = self::$repository->findById($id);
        if (!$linkObject) {
            return null;
        }
        return new LinkModel($linkObject);
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

    public function getAddress(): ?string {
        return $this->address;
    }
 
    public function setAddress(?string $address): self {
        $this->address = $address;
        return $this;
    }
 
    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }
 
    public function setCreatedAt(?string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?string {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?string $modifiedAt): self {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }
 
    public function getActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
    }



    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new LinkRepository();
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
}

LinkModel::init();