<?php

namespace Cursotopia\Entities;

class Chat {
    private ?int $id = null;
    private ?string $lastMessage = null;
    private ?string $lastMessageAt = null;
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

    public function getLastMessage(): ?string {
        return $this->lastMessage;
    }

    public function setLastMessage(?string $lastMessage): self {
        $this->lastMessage = $lastMessage;
        return $this;
    }

    public function getLastMessageAt(): ?string {
        return $this->lastMessageAt;
    }

    public function setLastMessageAt(?string $lastMessageAt): self {
        $this->lastMessageAt = $lastMessageAt;
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
