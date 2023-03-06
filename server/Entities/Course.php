<?php

namespace Cursotopia\Entities;

class Course {
    private int $id;
    private string $title;
    private string $description;
    private float $price;
    private int $imageId;
    private int $instructorId;
    private bool $approved;
    private int $approvedBy;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
