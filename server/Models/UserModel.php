<?php

namespace Cursotopia\Models;

use Bloom\Validations\Rules\Email;
use Bloom\Validations\Rules\Enum;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\User;
use Cursotopia\Repositories\Repository;
use Cursotopia\Repositories\UserRepository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class UserModel implements JsonSerializable {
    private static ?UserRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

    private ?int $id = null;

    #[Required("El nombre del usuario es requerido")]
    private ?string $name = null;

    #[Required("El apellido del usuario es requerido")]
    private ?string $lastName = null;

    #[Required("La fecha de nacimiento es requerida")]
    private ?string $birthDate = null;

    #[Required("El género es requerido")]
    #[Enum(["Masculino", "Femenino", "Otro"], "El genero no es válido")]
    private ?string $gender = null;

    #[Required("El correo electrónico es requerido")]
    #[Email("El correo electrónico no tiene el formato correcto")]
    private ?string $email = null;

    #[Required("La contraseña es requerida")]
    private ?string $password = null;

    private ?bool $enabled = null;

    #[Required("El rol de usuario es requerido")]
    private ?int $role = null;
    
    #[Required("La foto de perfil es requerida")]
    private ?int $profilePicture = null;

    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    // !!!
    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new UserRepository();
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

    // !!!
    public function save(): bool {
        $user = new User();
        $user
            ->setId($this->id)
            ->setName($this->name)
            ->setLastName($this->lastName)
            ->setBirthDate($this->birthDate)
            ->setGender($this->gender)
            ->setEmail($this->email)
            ->setPassword($this->password)
            ->setRole($this->role)
            ->setProfilePicture($this->profilePicture)
            ->setEnabled($this->enabled)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
            
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = self::$repository->create($user);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($user);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate(): ?string {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate): self {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getGender(): ?string {
        return $this->gender;
    }

    public function setGender(?string $gender): self {
        $this->gender = $gender;
        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(?string $password): self { 
        $this->password = $password;
        return $this;
    }

    public function getRole(): ?int {
        return $this->role;
    }

    public function setRole(?int $role): self {
        $this->role = $role;
        return $this;
    }

    public function getProfilePicture(): ?int {
        return $this->profilePicture;
    }

    public function setProfilePicture(?int $profilePicture): self {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function getEnabled(): ?bool {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self {
        $this->enabled = $enabled;
        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?string {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?string $modifiedAt): self {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
    }

    public static function findById(?int $id): ?UserModel {
        $object = self::$repository->findById($id);
        if (!$object) {
            return null;
        }

        return new UserModel($object);
    }

    public static function findOne(array $criteria): ?UserModel {
        $parameters = [];
        $valids = [ "id", "email" ];
        foreach ($criteria as $elementCriteria) {
            switch (count($elementCriteria)) {
                case 2: {
                    [ $name, $value ] = $elementCriteria;
                    if (in_array($name, $valids)) {
                        $parameters[$name] = $value;
                        $parameters[$name . "_opt"] = "=";
                    }
                    break;
                }
                case 3: {
                    [ $name, $operator, $value ] = $elementCriteria;
                    if (in_array($name, $valids)) {
                        $parameters[$name] = $value;
                        $parameters[$name . "_opt"] = $operator;
                    }
                    break;
                }
            }
        }
        $object = self::$repository->findOne2($parameters);
        if (!$object) {
            return null;
        }

        return new UserModel($object);
    }

    public static function findOneByEmail(string $email): ?array {
        $object = self::$repository->findOneByEmail($email);
        return $object;
    }

    public static function findUnblocked(): ?array {
        $object = self::$repository->findUnblocked();
        return $object;
    }

    public static function findBlocked(): ?array {
        return self::$repository->findBlocked();
    }

    public static function findAll($name, $role): ?array {
        return self::$repository->findAll($name, $role);
    }

    public static function findAllInstructors($name): ?array {
        return self::$repository->findAllInstructors($name);
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

UserModel::init();