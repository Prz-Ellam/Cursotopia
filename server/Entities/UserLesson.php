<?php

namespace Cursotopia\Entities;

class UserLesson {
    private int $id;
    private int $userId;
    private int $lessonId;
    private bool $isComplete;
    private string $completeAt;
    private string $lastTimeChecked;
    private string $createdAt;
    private string $modifiedAt;

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
     * Get the value of lessonId
     */ 
    public function getLessonId()
    {
        return $this->lessonId;
    }

    /**
     * Set the value of lessonId
     *
     * @return  self
     */ 
    public function setLessonId($lessonId)
    {
        $this->lessonId = $lessonId;

        return $this;
    }

    /**
     * Get the value of isComplete
     */ 
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     * Set the value of isComplete
     *
     * @return  self
     */ 
    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    /**
     * Get the value of completeAt
     */ 
    public function getCompleteAt()
    {
        return $this->completeAt;
    }

    /**
     * Set the value of completeAt
     *
     * @return  self
     */ 
    public function setCompleteAt($completeAt)
    {
        $this->completeAt = $completeAt;

        return $this;
    }

    /**
     * Get the value of lastTimeChecked
     */ 
    public function getLastTimeChecked()
    {
        return $this->lastTimeChecked;
    }

    /**
     * Set the value of lastTimeChecked
     *
     * @return  self
     */ 
    public function setLastTimeChecked($lastTimeChecked)
    {
        $this->lastTimeChecked = $lastTimeChecked;

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
}
