<?php

namespace Cursotopia\Entities;

class Category {
    private int $id;
    private string $name;
    private string $description;
    private bool $approved;
    private int $approvedBy;
    private int $createdBy;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
