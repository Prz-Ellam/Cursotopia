<?php

namespace Cursotopia\Models;

use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Video;
use Cursotopia\Repositories\VideoRepository;
use Cursotopia\ValueObjects\EntityState;

class VideoModel {
    private ?int $id = null;
    private ?string $name = null;
    
    #[Required("El tipo de la imagen es requerido")]
    #[Enum([ "video/mp4", "video/webm", "video/ogg" ], "El tipo de imagen no es válido")]
    private ?string $contentType;

    private ?string $duration = null;
    private ?string $address = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    private VideoRepository $videoRepository;
    private EntityState $entityState;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->contentType = $object["contentType"] ?? null;
        $this->duration = $object["duration"] ?? null;
        $this->address = $object["address"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
    
        $this->videoRepository = new VideoRepository();
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }
    

    public function save(): bool {
        $video = new Video();
        $video
            ->setId($this->id)
            ->setName($this->name)
            ->setContentType($this->contentType)
            ->setDuration($this->duration)
            ->setAddress($this->address)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
    
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $this->videoRepository->create($video);
                if ($rowsAffected) {
                    $this->id = intval($this->videoRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $this->videoRepository->update($video);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
}
