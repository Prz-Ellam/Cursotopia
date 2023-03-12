<?php

namespace Cursotopia\Entities;

class Message {
    private ?int $id = null;
    private ?string $message = null;
    private ?int $userId = null;
    private ?int $chatId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;
}
