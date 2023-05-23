<?php

namespace Cursotopia\Entities;

class Image {
    private ?int $id = null;
    private ?string $name = null;
    private ?int $size = null;
    private ?string $contentType = null;
    private ?string $data = null;
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

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getSize(): ?int {
        return $this->size;
    }

    public function setSize(?int $size): self {
        $this->size = $size;
        return $this;
    }

    public function getContentType(): ?string {
        return $this->contentType;
    }

    public function setContentType(?string $contentType): self {
        $this->contentType = $contentType;
        return $this;
    }

    public function getData(): ?string {
        return $this->data;
    }

    public function setData(?string $data): self {
        $this->data = $data;
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
