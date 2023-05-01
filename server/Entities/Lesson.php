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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of levelId
     */ 
    public function getLevelId()
    {
        return $this->levelId;
    }

    /**
     * Set the value of levelId
     *
     * @return  self
     */ 
    public function setLevelId($levelId)
    {
        $this->levelId = $levelId;

        return $this;
    }

    /**
     * Get the value of videoId
     */ 
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set the value of videoId
     *
     * @return  self
     */ 
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get the value of imageId
     */ 
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set the value of imageId
     *
     * @return  self
     */ 
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get the value of documentId
     */ 
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * Set the value of documentId
     *
     * @return  self
     */ 
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * Get the value of linkId
     */ 
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * Set the value of linkId
     *
     * @return  self
     */ 
    public function setLinkId($linkId)
    {
        $this->linkId = $linkId;

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
    public function isActive()
    {
        return $this->active ? 1 : 0;
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
