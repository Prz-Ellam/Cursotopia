<?php

namespace Cursotopia\Entities;

class Level {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?bool $free = null;
    private ?int $courseId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;
 
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }
 
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function isFree() {
        return $this->free ? 1 : 0;
    }

    public function setFree($free) {
        $this->free = $free;
        return $this;
    }

    public function getCourseId() {
        return $this->courseId;
    }

    public function setCourseId($courseId) {
        $this->courseId = $courseId;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    public function setModifiedAt($modifiedAt) {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getActive() {
        return $this->active ? 1 : 0;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }
}
