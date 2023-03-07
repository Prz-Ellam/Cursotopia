<?php

namespace Cursotopia\Entities;

class Lesson {
    private int $id;
    private string $title;
    private string $description;
    private int $levelId;
    private int $videoId;
    private int $imageId;
    private int $documentId;
    private int $linkId;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
