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

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getCourseId() {
        return $this->courseId;
    }

    public function setCourseId($courseId) {
        $this->courseId = $courseId;
        return $this;
    }

    public function getStudentId() {
        return $this->studentId;
    }

    public function setStudentId($studentId) {
        $this->studentId = $studentId;
        return $this;
    }

    public function getIsFinished() {
        return $this->isFinished;
    }

    public function setIsFinished($isFinished) {
        $this->isFinished = $isFinished;
        return $this;
    }
 
    public function getEnrollDate() {
        return $this->enrollDate;
    }
 
    public function setEnrollDate($enrollDate) {
        $this->enrollDate = $enrollDate;
        return $this;
    }

    public function getFinishDate() {
        return $this->finishDate;
    }

    public function setFinishDate($finishDate) {
        $this->finishDate = $finishDate;
        return $this;
    }
 
    public function getCertificateUid() {
        return $this->certificateUid;
    }

    public function setCertificateUid($certificateUid) {
        $this->certificateUid = $certificateUid;
        return $this;
    }
 
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }
 
    public function getPaymentMethodId() {
        return $this->paymentMethodId;
    }

    public function setPaymentMethodId($paymentMethodId) {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getLastTimeChecked() {
        return $this->lastTimeChecked;
    }

    public function setLastTimeChecked($lastTimeChecked) {
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

    public function getIsPaid() {
        return $this->isPaid;
    }

    public function setIsPaid($isPaid) {
        $this->isPaid = $isPaid;
        return $this;
    }
}
