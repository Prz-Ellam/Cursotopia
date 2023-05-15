<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Review;
use Cursotopia\Repositories\Repository;
use Cursotopia\Repositories\ReviewRepository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class ReviewModel implements JsonSerializable {
    private static ?ReviewRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;
    private ?string $message = null;
    private ?int $rate = null;
    private ?int $courseId = null;
    private ?int $userId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function setMessage(?string $message): self {
        $this->message = $message;
        return $this;
    }
 
    public function getRate(): ?int {
        return $this->rate;
    }

    public function setRate(?int $rate): self {
        $this->rate = $rate;
        return $this;
    }

    public function getCourseId(): ?int {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): self {
        $this->courseId = $courseId;
        return $this;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(?int $userId): self {
        $this->userId = $userId;
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

    public function isActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
    }

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
        $review = new Review();
        $review
            ->setId($this->id)
            ->setMessage($this->message)
            ->setRate($this->rate)
            ->setCourseId($this->courseId)
            ->setUserId($this->userId)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($review);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($review);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findById(?int $id): ?ReviewModel {
        $reviewObject = self::$repository->findById($id);
        if (!$reviewObject) {
            return null;
        }
        return new ReviewModel($reviewObject);
    }

    public static function findOneByCourseAndUserId(?int $courseId, ?int $userId): ?ReviewModel {
        $reviewObject = self::$repository->findOneByCourseAndUserId($courseId, $userId);
        if (!$reviewObject) {
            return null;
        }
        return new ReviewModel($reviewObject);
    }

    public static function findByCourse(int $courseId, int $pageNum, int $pageSize): ?array {
        return self::$repository->findByCourse($courseId, $pageNum, $pageSize);
    }

    public static function findTotalByCourse(int $courseId) {
        return self::$repository->findTotalByCourse($courseId)["total"];
    }

    

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new ReviewRepository();
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

ReviewModel::init();