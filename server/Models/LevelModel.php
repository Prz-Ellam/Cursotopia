<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Cursotopia\Entities\Level;
use Cursotopia\Repositories\LevelRepository;
use Cursotopia\ValueObjects\EntityState;

class LevelModel {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?float $price = null;
    private ?int $courseId = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->title = $object["title"] ?? null;
        $this->description = $object["description"] ?? null;
        $this->price = $object["price"] ?? null;
        $this->courseId = $object["courseId"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }

    public function save(): bool {
        $level = new Level();
        $level
            ->setId($this->id)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setPrice($this->price)
            ->setCourseId($this->courseId)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $levelRepository = new LevelRepository();
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $levelRepository->create($level);
                if ($rowsAffected) {
                    $this->setId(intval(DB::lastInsertId()));
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $levelRepository->update($level);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findOneById(int $id) {
        $levelRepository = new LevelRepository();
        $object = $levelRepository->findOne($id);
        return new LevelModel($object);
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
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
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
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

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
