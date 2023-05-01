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

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getLessonId() {
        return $this->lessonId;
    }

    public function setLessonId($lessonId) {
        $this->lessonId = $lessonId;
        return $this;
    }

    public function getIsComplete() {
        return $this->isComplete;
    }

    public function setIsComplete($isComplete) {
        $this->isComplete = $isComplete;
        return $this;
    }

    public function getCompleteAt() {
        return $this->completeAt;
    }

    public function setCompleteAt($completeAt) {
        $this->completeAt = $completeAt;
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
}
