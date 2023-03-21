<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\UserRoleRepository;

class UserRoleModel {
    private int $id;
    private string $name;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    public function __construct() {
        
    }

    public function findOneById(int $id) {
        
    }

    public static function findAllByIsPublic(bool $isPublic): array {
        $userRoleRepository = new UserRoleRepository();
        return $userRoleRepository->findAllByIsPublic($isPublic);
    }

    public static function findOneByIdAndIsPublic(int $id, bool $isPublic): ?array {
        $userRoleRepository = new UserRoleRepository();
        return $userRoleRepository->findOneByIdAndIsPublic($id, $isPublic);
    }
}
