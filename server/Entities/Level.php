<?php

namespace Cursotopia\Entities;

class Level {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?bool $free = null;
    private ?int $courseId = null;
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

    public function isFree(): ?bool {
        return $this->free;
    }

    public function setFree(?bool $free): self {
        $this->free = $free;
        return $this;
    }

    public function getCourseId(): ?int {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): self {
        $this->courseId = $courseId;
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
