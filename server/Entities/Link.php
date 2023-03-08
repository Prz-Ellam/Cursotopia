<?php

namespace Cursotopia\Entities;

class Link {
    private int $id;
    private string $name;
    private string $address;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;

    /**
     * Get the value of id
     */ 
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address): self {
        $this->address = $address;
        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt(): string {
        return $this->modifiedAt;
    }

    /**
     * Set the value of modifiedAt
     *
     * @return  self
     */ 
    public function setModifiedAt($modifiedAt): self {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive(): bool {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active): self {
        $this->active = $active;
        return $this;
    }
}
