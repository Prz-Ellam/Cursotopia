<?php

namespace Cursotopia\Entities;

class Chat
{
    private ?int $id = null;
    private ?string $lastMessage = null;
    private ?string $lastMessageAt = null;
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

    public function getLastMessage() {
        return $this->lastMessage;
    }

    public function setLastMessage($lastMessage) {
        $this->lastMessage = $lastMessage;
        return $this;
    }

    public function getLastMessageAt() {
        return $this->lastMessageAt;
    }

    public function setLastMessageAt($lastMessageAt) {
        $this->lastMessageAt = $lastMessageAt;
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
