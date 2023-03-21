<?php

namespace Cursotopia\Entities;

class ChatParticipant {
    private ?int $id = null;
    private ?int $userId = null;
    private ?int $chatId = null;
    private ?string $createdAt = null;
    private ?string $mdifiedAt = null;
    private ?int $active = null;

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
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of chatId
     */ 
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * Set the value of chatId
     *
     * @return  self
     */ 
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;

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
     * Get the value of mdifiedAt
     */ 
    public function getMdifiedAt()
    {
        return $this->mdifiedAt;
    }

    /**
     * Set the value of mdifiedAt
     *
     * @return  self
     */ 
    public function setMdifiedAt($mdifiedAt)
    {
        $this->mdifiedAt = $mdifiedAt;

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