<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Review;
use Cursotopia\Repositories\ReviewRepository;
use Cursotopia\ValueObjects\EntityState;

class ReviewModel {
    private ?int $id = null;
    private ?string $message = null;
    private ?int $rate = null;
    private ?string $courseId = null;
    private ?int $userId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->message = $object["message"] ?? null;
        $this->rate = $object["rate"] ?? null;
        $this->courseId = $object["courseId"] ?? null;
        $this->userId = $object["userId"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
    
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

        $reviewRepository = new ReviewRepository();
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $reviewRepository->create($review);
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $reviewRepository->update($review);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findById(int $id) {
        $reviewRepository = new ReviewRepository();
        $reviewObject = $reviewRepository->findById($id);
        if (!$reviewObject) {
            return null;
        }
        return new ReviewModel($reviewObject);
    }

    public static function findObjById(int $id): ?array {
        $reviewRepository = new ReviewRepository();
        $reviewObject = $reviewRepository->findById($id);
        if (!$reviewObject) {
            return null;
        }
        return new ReviewModel($reviewObject);
    }

    public static function delete(int $id) {
        $reviewRepository = new ReviewRepository();
        $rowsAffected = $reviewRepository->delete($id);
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findOneByCourseAndUserId(int $courseId, int $userId): ?array {
        $repository = new ReviewRepository();
        $object = $repository->findOneByCourseAndUserId($courseId, $userId);
        return $object;
    }

    public static function findByCourse(int $courseId,int $pageNum,int $pageSize): ?array {
        $repository = new ReviewRepository();
        $object = $repository->findByCourse($courseId,$pageNum,$pageSize);
        return $object;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
}
