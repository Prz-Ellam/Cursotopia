<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\RoleRepository;
use Cursotopia\ValueObjects\EntityState;

class RoleModel {
    private static ?RoleRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;
    private ?string $name = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new RoleRepository();
        }
    }

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
        return self::$repository->findAllByIsPublic($isPublic);
    }

    public static function findOneByIdAndIsPublic(int $id, bool $isPublic): ?array {
        return self::$repository->findOneByIdAndIsPublic($id, $isPublic);
    }
}

RoleModel::init();