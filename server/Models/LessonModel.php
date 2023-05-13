<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Lesson;
use Cursotopia\Repositories\LessonRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class LessonModel implements JsonSerializable {
    private static ?LessonRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];
    
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?int $levelId = null;
    private ?int $videoId = null;
    private ?int $imageId = null;
    private ?int $documentId = null;
    private ?int $linkId = null;
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
        $lesson = new Lesson();
        $lesson
            ->setId($this->id)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setLevelId($this->levelId)
            ->setVideoId($this->videoId)
            ->setImageId($this->imageId)
            ->setDocumentId($this->documentId)
            ->setLinkId($this->linkId)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($lesson);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($lesson);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public static function findById(?int $id): ?LessonModel {
        $lessonObject = self::$repository->findById($id);
        if (!$lessonObject) {
            return null;
        }
        return new LessonModel($lessonObject);
    }

    public static function findObjById(?int $id): ?array {
        $lessonObject = self::$repository->findById($id);
        if (!$lessonObject) {
            return null;
        }
        return new LessonModel($lessonObject);
    }

    public static function findByLevel(int $levelId) {
        return self::$repository->findByLevel($levelId);
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

    public function getLevelId() {
        return $this->levelId;
    }

    public function setLevelId($levelId) {
        $this->levelId = $levelId;
        return $this;
    }

    public function getVideoId() {
        return $this->videoId;
    }

    public function setVideoId($videoId) {
        $this->videoId = $videoId;
        return $this;
    }

    public function getImageId() {
        return $this->imageId;
    }

    public function setImageId($imageId) {
        $this->imageId = $imageId;
        return $this;
    }

    public function getDocumentId() {
        return $this->documentId;
    }
 
    public function setDocumentId($documentId) {
        $this->documentId = $documentId;
        return $this;
    }

    public function getLinkId() {
        return $this->linkId;
    }

    public function setLinkId($linkId) {
        $this->linkId = $linkId;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    public function setModifiedAt($modifiedAt) {
        $this->modifiedAt = $modifiedAt;
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
            self::$repository = new LessonRepository();
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

LessonModel::init();