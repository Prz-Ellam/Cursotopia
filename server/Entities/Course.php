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

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
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

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): self {
        $this->price = $price;
        return $this;
    }

    public function getImageId(): ?int {
        return $this->imageId;
    }

    public function setImageId(?int $imageId): self {
        $this->imageId = $imageId;
        return $this;
    }

    public function getInstructorId(): ?int {
        return $this->instructorId;
    }

    public function setInstructorId(?int $instructorId): self {
        $this->instructorId = $instructorId;
        return $this;
    }

    public function getIsComplete(): ?bool {
        return $this->isComplete;
    }

    public function setIsComplete(?bool $isComplete): self {
        $this->isComplete = $isComplete;
        return $this;
    }

    public function isApproved(): ?bool {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self {
        $this->approved = $approved;
        return $this;
    }

    public function getApprovedBy(): ?int {
        return $this->approvedBy;
    }

    public function setApprovedBy(?int $approvedBy): self {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public function getApprovedAt(): ?string {
        return $this->approvedAt;
    }

    public function setApprovedAt(?string $approvedAt): self {
        $this->approvedAt = $approvedAt;
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