<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Enrollment;
use Cursotopia\Repositories\EnrollmentRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class EnrollmentModel implements JsonSerializable {
    private static ?EnrollmentRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

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
                $rowsAffected = self::$repository->create($enrollment);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
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
        $status = self::$repository->completeLesson($userId, $lessonId);
        return $status ? true : false;
    }

    public static function visitLesson(int $userId, int $lessonId): bool {
        $status = self::$repository->visitLesson($userId, $lessonId);
        return $status ? true : false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getCourseId(): ?int {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): self {
        $this->courseId = $courseId;
        return $this;
    }

    public function getStudentId(): ?int {
        return $this->studentId;
    }

    public function setStudentId(?int $studentId): self {
        $this->studentId = $studentId;
        return $this;
    }

    public function getIsFinished(): ?bool {
        return $this->isFinished;
    }

    public function setIsFinished(?bool $isFinished): self {
        $this->isFinished = $isFinished;
        return $this;
    }

    public function getEnrollDate(): ?string {
        return $this->enrollDate;
    }

    public function setEnrollDate(?string $enrollDate): self {
        $this->enrollDate = $enrollDate;
        return $this;
    }

    public function getFinishDate(): ?string {
        return $this->finishDate;
    }

    public function setFinishDate(?string $finishDate): self {
        $this->finishDate = $finishDate;
        return $this;
    }

    public function getCertificateUid(): ?string {
        return $this->certificateUid;
    }
 
    public function setCertificateUid(?string $certificateUid): self {
        $this->certificateUid = $certificateUid;
        return $this;
    }
 
    public function getAmount(): ?float {
        return $this->amount;
    }
 
    public function setAmount(?float $amount): self {
        $this->amount = $amount;
        return $this;
    }

    public function getIsPaid(): ?bool {
        return $this->isPaid;
    }
 
    public function setIsPaid(?bool $isPaid): self {
        $this->isPaid = $isPaid;
        return $this;
    }

    public function getPaymentMethodId(): ?int {
        return $this->paymentMethodId;
    }
 
    public function setPaymentMethod(?int $paymentMethodId): self {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getLastTimeChecked(): ?string {
        return $this->lastTimeChecked;
    }
 
    public function setLastTimeChecked(?string $lastTimeChecked): self {
        $this->lastTimeChecked = $lastTimeChecked;
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

    public static function findOneByCourseIdAndStudentId(?int $courseId, ?int $studentId): ?EnrollmentModel {
        $object = self::$repository->findOneByCourseAndStudent($courseId, $studentId);
        if (!$object) {
            return null;
        }
        return new EnrollmentModel($object);
    }

    public static function findOneCertificate(?int $studentId, ?int $courseId): ?array {
        return self::$repository->certificateFindOne($studentId, $courseId);
    }



    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new EnrollmentRepository();
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
        return json_decode(json_encode($members), true);
    }

    public static function getProperties(): array {
        return array_keys(get_class_vars(self::class));
    }
}

EnrollmentModel::init();