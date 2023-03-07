<?php

namespace Cursotopia\Entities;

class Review {
    private int $id;
    private string $message;
    private int $rate;
    private int $courseId;
    private int $userId;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
