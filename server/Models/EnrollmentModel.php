<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Repositories\EnrollmentRepository;
use Cursotopia\ValueObjects\EntityState;

class EnrollmentModel {
    private ?int $id = null;
    private ?int $courseId = null;
    private ?int $studentId = null;
    private ?bool $isFinished = null;
    private ?string $enrollDate = null;
    private ?string $finishDate = null;
    private ?string $certificateUid = null;
    private ?float $amount = null;
    private ?int $paymentMethodId = null;
    private ?bool $isPaid = null;
    private ?string $lastTimeChecked = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->courseId = $object["courseId"] ?? null;
        $this->studentId = $object["studentId"] ?? null;
        $this->isFinished = $object["isFinished"] ?? null;
        $this->enrollDate = $object["enrollDate"] ?? null;
        $this->certificateUid = $object["certificateUid"] ?? null;
        $this->amount = $object["amount"] ?? null;
        $this->paymentMethodId = $object["paymentMethodId"] ?? null;
        $this->lastTimeChecked = $object["lastTimeChecked"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }

    public function save(): bool {
        $enrollmentRepository = new EnrollmentRepository();
        $enrollment = new Enrollment();
        $enrollment
            ->setId($this->id)
            ->setCourseId($this->courseId)
            ->setStudentId($this->studentId)
            ->setIsFinished($this->isFinished)
            ->setEnrollDate($this->enrollDate)
            ->setFinishDate($this->finishDate)
            ->setCertificateUid($this->certificateUid)
            ->setAmount($this->amount)
            ->setPaymentMethodId($this->paymentMethodId)
            ->setIsPaid($this->isPaid)
            ->setLastTimeChecked($this->lastTimeChecked)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
        
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $enrollmentRepository->create($enrollment);
                if ($rowsAffected) {
                    $this->id = intval($enrollmentRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                //$rowsAffected = $this->enrollmentRepository->update($enrollment);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public static function completeLesson(int $userId, int $lessonId): bool {
        $enrollmentRepository = new EnrollmentRepository();
        $status = $enrollmentRepository->completeLesson($userId, $lessonId);
        return $status ? true : false;
    }

    public static function visitLesson(int $userId, int $lessonId): bool {
        $enrollmentRepository = new EnrollmentRepository();
        $status = $enrollmentRepository->visitLesson($userId, $lessonId);
        return $status ? true : false;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    /**
     * Get the value of courseId
     */ 
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set the value of courseId
     *
     * @return  self
     */ 
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;

        return $this;
    }

    /**
     * Get the value of studentId
     */ 
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set the value of studentId
     *
     * @return  self
     */ 
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get the value of isFinished
     */ 
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Set the value of isFinished
     *
     * @return  self
     */ 
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
        return $this;
    }

    /**
     * Get the value of enrollDate
     */ 
    public function getEnrollDate()
    {
        return $this->enrollDate;
    }

    /**
     * Set the value of enrollDate
     *
     * @return  self
     */ 
    public function setEnrollDate($enrollDate)
    {
        $this->enrollDate = $enrollDate;

        return $this;
    }

    /**
     * Get the value of finishDate
     */ 
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Set the value of finishDate
     *
     * @return  self
     */ 
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    /**
     * Get the value of finishDate
     */ 
    public function getCertificateUid()
    {
        return $this->certificateUid;
    }

    /**
     * Set the value of finishDate
     *
     * @return  self
     */ 
    public function setCertificateUid($certificateUid)
    {
        $this->certificateUid = $certificateUid;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of paymentMethod
     */ 
    public function getPaymentMethodId()
    {
        return $this->paymentMethodId;
    }

    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */ 
    public function setPaymentMethod($paymentMethodId)
    {
        $this->paymentMethodId = $paymentMethodId;

        return $this;
    }

    /**
     * Get the value of lastTimeChecked
     */ 
    public function getLastTimeChecked()
    {
        return $this->lastTimeChecked;
    }

    /**
     * Set the value of lastTimeChecked
     *
     * @return  self
     */ 
    public function setLastTimeChecked($lastTimeChecked)
    {
        $this->lastTimeChecked = $lastTimeChecked;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set the value of modifiedAt
     *
     * @return  self
     */ 
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

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

    public static function findOneByCourseIdAndStudentId(int $courseId, int $studentId) {
        $repository = new EnrollmentRepository();
        $object = $repository->findOneByCourseAndStudent($courseId, $studentId);
        if (!$object) {
            return null;
        }
        return new EnrollmentModel($object);
    }

    /**
     * Get the value of isPaid
     */ 
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set the value of isPaid
     *
     * @return  self
     */ 
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;

        return $this;
    }
}
