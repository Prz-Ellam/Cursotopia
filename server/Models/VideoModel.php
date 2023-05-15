<?php

namespace Cursotopia\Models;

use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\Video;
use Cursotopia\Repositories\Repository;
use Cursotopia\Repositories\VideoRepository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class VideoModel implements JsonSerializable {
    private static ?VideoRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;
    private ?string $name = null;
    
    #[Required("El tipo de la imagen es requerido")]
    #[Enum([ "video/mp4", "video/webm", "video/ogg" ], "El tipo de imagen no es válido")]
    private ?string $contentType = null;

    private ?string $duration = null;
    private ?string $address = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new VideoRepository();
        }
    }

    public function __construct(?array $data = null) {
        $properties = get_object_vars($this);
        foreach ($properties as $name => $value) {
            if ($value instanceof Repository || $value instanceof EntityState) {
                continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            $this->$name = (isset($data[$name])) ? $data[$name] : null;
        }
    
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
                $rowsAffected = self::$repository->create($video);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($video);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    public static function findById(?int $id): ?VideoModel {
        $videoObject = self::$repository->findById($id);
        if (!$videoObject) {
            return null;
        }
        return new VideoModel($videoObject);
    }
 
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getName() {
        return $this->name;
    }
 
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

        /**
     * Get the value of contentType
     */ 
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the value of contentType
     *
     * @return  self
     */ 
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get the value of duration
     */ 
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @return  self
     */ 
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

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



    public function toArray(): ?array {
        return json_decode(json_encode($this), true);
    }

    public function jsonSerialize(): mixed {
        $properties = get_object_vars($this);
        $output = [];
        
        foreach ($properties as $name => $value) {
            if (in_array($name, $this->_ignores)) {
                 continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            if (!($value instanceof Repository) && !($value instanceof EntityState)) {
                $output[$name] = $value;
            }
        }
        
        return $output;
    }

    public function setIgnores(array $ignores) {
        $this->_ignores = $ignores;
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}

VideoModel::init();