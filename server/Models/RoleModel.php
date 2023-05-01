<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\RoleRepository;

class RoleModel {
    private int $id;
    private string $name;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
 
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    public function getActive() {
        return $this->active;
    }

    public function __construct() {
        
    }

    public function findOneById(int $id) {
        
    }

    public static function findAllByIsPublic(bool $isPublic): array {
        $roleRepository = new RoleRepository();
        return $roleRepository->findAllByIsPublic($isPublic);
    }

    public static function findOneByIdAndIsPublic(int $id, bool $isPublic): ?array {
        $userRoleRepository = new RoleRepository();
        return $userRoleRepository->findOneByIdAndIsPublic($id, $isPublic);
    }
}
