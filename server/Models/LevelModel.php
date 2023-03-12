<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\LevelRepository;
use Cursotopia\ValueObjects\EntityState;

class LevelModel {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?float $price;
    private ?int $courseId;
    private ?string $createdAt;
    private ?string $modifiedAt;
    private ?bool $active;

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
        $levelRepository = new LevelRepository();
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $levelRepository->create();
                break;
            }
            case EntityState::UPDATE: {
                $levelRepository->update();
                break;
            }
        }
        return true;
    }
}
