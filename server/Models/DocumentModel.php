<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Document;
use Cursotopia\Repositories\DocumentRepository;
use Cursotopia\ValueObjects\EntityState;

class DocumentModel {
    private ?int $id = null;
    private ?string $name = null;
    private ?string $contentType = null;
    private ?string $address = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private DocumentRepository $documentRepository;
    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->contentType = $object["contentType"] ?? null;
        $this->address = $object["address"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
    
        $this->documentRepository = new DocumentRepository();
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }
    
    public function save(): bool {
        $document = new Document();
        $document
            ->setId($this->id)
            ->setName($this->name)
            ->setContentType($this->contentType)
            ->setAddress($this->address)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
    
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $this->documentRepository->create($document);
                if ($rowsAffected) {
                    $this->id = intval($this->documentRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $this->documentRepository->update($document);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id) {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name) {
        $this->name = $name;
        return $this;
    }

    public function getContentType(): ?string {
        return $this->contentType;
    }

    public function setContentType(?string $contentType) {
        $this->contentType = $contentType;
        return $this;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address) {
        $this->address = $address;
        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?string {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?string $modifiedAt) {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function isActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active) {
        $this->active = $active;
        return $this;
    }
}
