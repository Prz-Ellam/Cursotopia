<?php

namespace Cursotopia\Entities;

class MessageView {
    private ?int $id = null;
    private ?int $messageId = null;
    private ?int $userId = null;
    private ?string $viewedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getMessageId(): ?int {
        return $this->messageId;
    }

    public function setMessageId(?int $messageId): self {
        $this->messageId = $messageId;
        return $this;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(?int $userId): self {
        $this->userId = $userId;
        return $this;
    }

    public function getViewedAt(): ?string {
        return $this->viewedAt;
    }

    public function setViewedAt(?string $viewedAt): self {
        $this->viewedAt = $viewedAt;
        return $this;
    }
}
