<?php

namespace Cursotopia\Entities;

class UserLesson {
    private ?int $id = null;
    private ?int $userId = null;
    private ?int $lessonId = null;
    private ?bool $isComplete = null;
    private ?string $completeAt = null;
    private ?string $lastTimeChecked = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(?int $userId): self {
        $this->userId = $userId;
        return $this;
    }

    public function getLessonId(): ?int {
        return $this->lessonId;
    }

    public function setLessonId(?int $lessonId): self {
        $this->lessonId = $lessonId;
        return $this;
    }

    public function getIsComplete(): ?bool {
        return $this->isComplete;
    }

    public function setIsComplete(?bool $isComplete): self {
        $this->isComplete = $isComplete;
        return $this;
    }

    public function getCompleteAt(): ?string {
        return $this->completeAt;
    }

    public function setCompleteAt(?string $completeAt): self {
        $this->completeAt = $completeAt;
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
}
