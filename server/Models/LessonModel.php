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

    public static function findByLevel(int $levelId) {
        return self::$repository->findByLevel($levelId);
    }
 
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }
 
    public function setTitle(?string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getLevelId(): ?int {
        return $this->levelId;
    }

    public function setLevelId(?int $levelId): self {
        $this->levelId = $levelId;
        return $this;
    }

    public function getVideoId(): ?int {
        return $this->videoId;
    }

    public function setVideoId(?int $videoId): self {
        $this->videoId = $videoId;
        return $this;
    }

    public function getImageId(): ?int {
        return $this->imageId;
    }

    public function setImageId(?int $imageId): self {
        $this->imageId = $imageId;
        return $this;
    }

    public function getDocumentId(): ?int {
        return $this->documentId;
    }
 
    public function setDocumentId(?int $documentId): self {
        $this->documentId = $documentId;
        return $this;
    }

    public function getLinkId(): ?int {
        return $this->linkId;
    }

    public function setLinkId(?int $linkId): self {
        $this->linkId = $linkId;
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

    public function getInstructorId(): ?int {
        return $this->instructorId;
    }

    public function getCourseIsComplete(): ?bool {
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