<?php

namespace Cursotopia\Entities;

class Message {
    private int $id;
    private string $message;
    private int $userId;
    private int $chatId;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
