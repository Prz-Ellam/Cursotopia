<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Link;
use Cursotopia\Repositories\LinkRepository;
use Cursotopia\ValueObjects\EntityState;

class LinkModel {
    private ?int $id = null;
    private ?string $name = null;
    private ?string $address = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;
    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->address = $object["address"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
    
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }
    
    public function save(): bool {
        $linkRepository = new LinkRepository();
        $link = new Link();
        $link
            ->setId($this->id)
            ->setName($this->name)
            ->setAddress($this->address)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $linkRepository->create($link);
                if ($rowsAffected) {
                    $this->id = intval($linkRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $linkRepository->update($link);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public static function findById(?int $id): ?array {
        $linkRepository = new LinkRepository();
        return $linkRepository->findById($id);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set the value of modifiedAt
     *
     * @return  self
     */ 
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
