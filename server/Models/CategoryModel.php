<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Cursotopia\Entities\Category;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\ValueObjects\EntityState;

class CategoryModel {
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?bool $approved;
    private ?int $approvedBy;
    private ?int $createdBy;
    private ?string $createdAt;
    private ?string $modifiedAt;
    private ?bool $active;

    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->description = $object["description"] ?? null;
        $this->approved = $object["approved"] ?? null;
        $this->approvedBy = $object["approvedBy"] ?? null;
        $this->createdBy = $object["createdBy"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }

    public function save(): bool {
        $categoryRepository = new CategoryRepository();

        $category = new Category();
        $category
            ->setId($this->id)
            ->setName($this->name)
            ->setDescription($this->description)
            ->setApproved($this->approved)
            ->setApprovedBy($this->approvedBy)
            ->setCreatedBy($this->createdBy)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);

        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $categoryRepository->create($category);
                if ($rowsAffected) {
                    $this->setId(intval(DB::lastInsertId()));
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $categoryRepository->update($category);
                break;
            }
        }

        return ($rowsAffected > 0) ? true : false;
    }

    /**
     * Get the value of createdBy
     */ 
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     *
     * @return  self
     */ 
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
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
    public function setId($id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
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

    public static function findOneById(int $id) {
        $repository = new CategoryRepository();
        $object = $repository->findOne($id);
        return new CategoryModel($object);
    }

    public static function findAll() {
        $repository = new CategoryRepository();
        return $repository->findAll();
    }
}
