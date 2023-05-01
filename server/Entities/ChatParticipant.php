<?php

namespace Cursotopia\Entities;

class ChatParticipant {
    private ?int $id = null;
    private ?int $userId = null;
    private ?int $chatId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?int $active = null;

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

    public function getChatId() {
        return $this->chatId;
    }

    public function setChatId($chatId) {
        $this->chatId = $chatId;
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
}