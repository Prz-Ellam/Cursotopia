<?php

namespace Cursotopia\Entities;

class Chat {
    private ?int $id = null;
    private ?string $lastMessage = null;
    private ?string $lastMessageAt = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

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
     * Get the value of lastMessage
     */ 
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * Set the value of lastMessage
     *
     * @return  self
     */ 
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get the value of lastMessageAt
     */ 
    public function getLastMessageAt()
    {
        return $this->lastMessageAt;
    }

    /**
     * Set the value of lastMessageAt
     *
     * @return  self
     */ 
    public function setLastMessageAt($lastMessageAt)
    {
        $this->lastMessageAt = $lastMessageAt;

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
