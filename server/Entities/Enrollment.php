<?php

namespace Cursotopia\Entities;

class Enrollment {
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

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
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
 
    public function getPaymentMethodId(): ?int {
        return $this->paymentMethodId;
    }

    public function setPaymentMethodId(?int $paymentMethodId): self {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getIsPaid(): ?bool {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self {
        $this->isPaid = $isPaid;
        return $this;
    }

    public function getLastTimeChecked(): ?string {
        return $this->lastTimeChecked;
    }

    public function setLastTimeChecked(?string $lastTimeChecked): self {
        $this->lastTimeChecked = $lastTimeChecked;
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
}
