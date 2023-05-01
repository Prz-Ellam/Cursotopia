<?php

namespace Cursotopia\Entities;

class Course {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?float $price = null;
    private ?int $imageId = null;
    private ?int $instructorId = null;
    private ?bool $isComplete = null;
    private ?bool $approved = null;
    private ?int $approvedBy = null;
    private ?string $approvedAt = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function getImageId() {
        return $this->imageId;
    }

    public function setImageId($imageId) {
        $this->imageId = $imageId;
        return $this;
    }

    public function getInstructorId() {
        return $this->instructorId;
    }

    public function setInstructorId($instructorId) {
        $this->instructorId = $instructorId;
        return $this;
    }

    public function getApproved() {
        return $this->approved ? 1 : 0;
    }

    public function setApproved($approved) {
        $this->approved = $approved;
        return $this;
    }

    public function getApprovedBy() {
        return $this->approvedBy;
    }

    public function setApprovedBy($approvedBy) {
        $this->approvedBy = $approvedBy;
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

    public function getIsComplete() {
        return $this->isComplete;
    }

    public function setIsComplete($isComplete) {
        $this->isComplete = $isComplete;
        return $this;
    }

    public function getApprovedAt() {
        return $this->approvedAt;
    }

    public function setApprovedAt($approvedAt) {
        $this->approvedAt = $approvedAt;
        return $this;
    }
}
