<?php

namespace Cursotopia\Entities;

class Category {
    private int $id;
    private string $name;
    private string $description;
    private bool $approved;
    private int $approvedBy;
    private int $createdBy;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getApproved(): bool {
        return $this->approved;
    }

    public function setApproved(bool $approved): self {
        $this->approved = $approved;
        return $this;
    }

    public function getApprovedBy(): int {
        return $this->approvedBy;
    }

    public function setApprovedBy(int $approvedBy): self {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public function getCreatedBy(): int {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): self {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): string {
        return $this->modifiedAt;
    }

    public function setModifiedAt(string $modifiedAt): self {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getActive(): bool {
        return $this->active;
    }

    public function setActive(bool $active): self {
        $this->active = $active;
        return $this;
    }
}
