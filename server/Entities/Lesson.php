<?php

namespace Cursotopia\Entities;

class Lesson {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?int $levelId = null;
    private ?int $videoId = null;
    private ?int $imageId = null;
    private ?int $documentId = null;
    private ?int $linkId = null;
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

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getLevelId(): ?int {
        return $this->levelId;
    }

    public function setLevelId(?int $levelId): self {
        $this->levelId = $levelId;
        return $this;
    }

    public function getVideoId(): ?int {
        return $this->videoId;
    }

    public function setVideoId(?int $videoId): self {
        $this->videoId = $videoId;
        return $this;
    }
 
    public function getImageId(): ?int {
        return $this->imageId;
    }

    public function setImageId(?int $imageId): self {
        $this->imageId = $imageId;
        return $this;
    }

    public function getDocumentId(): ?int {
        return $this->documentId;
    }

    public function setDocumentId(?int $documentId): self {
        $this->documentId = $documentId;
        return $this;
    }

    public function getLinkId(): ?int {
        return $this->linkId;
    }

    public function setLinkId(?int $linkId): self {
        $this->linkId = $linkId;
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
