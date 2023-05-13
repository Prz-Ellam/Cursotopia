<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Level;
use Cursotopia\Repositories\LevelRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class LevelModel implements JsonSerializable {
    private static ?LevelRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];
    
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?bool $free = null;
    private ?int $courseId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private ?int $instructorId = null;
    private ?bool $courseIsComplete = null;

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
        $level = new Level();
        $level
            ->setId($this->id)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setFree($this->free)
            ->setCourseId($this->courseId)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($level);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($level);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findOneById(int $id) {
        $object = self::$repository->findById($id);
        return new LevelModel($object);
    }

    public static function findById(?int $id): ?LevelModel {
        $levelObject = self::$repository->findById($id);
        if (!$levelObject) {
            return null;
        }
        return new LevelModel($levelObject);
    }

    public static function findObjById(?int $id): ?array {
        return self::$repository->findById($id);
    }

    public static function findByCourse(int $courseId): array {
        return self::$repository->findByCourse($courseId);
    }

    public function getId() {
        return $this->id;
    }
 
    public function setId($id) {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
 
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function isFree() {
        return $this->free;
    }
 
    public function setFree($free) {
        $this->free = $free;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function getInstructorId() {
        return $this->instructorId;
    }

    public function getCourseIsComplete() {
        return $this->courseIsComplete;
    }



    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new LevelRepository();
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

LevelModel::init();