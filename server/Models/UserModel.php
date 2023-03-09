<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Bloom\Hashing\Crypto;
use Bloom\Validations\Rules\Email;
use Bloom\Validations\Rules\EqualTo;
use Bloom\Validations\Rules\Required;
use Cursotopia\Entities\User;
use Cursotopia\Contracts\UserRepositoryInterface;
use Cursotopia\Repositories\AuthRepository;
use Cursotopia\Repositories\UserRepository;
use Cursotopia\ValueObjects\EntityState;
use Exception;

class UserModel {
    private UserRepositoryInterface $userRepository;
    private AuthRepository $authRepository;
    private EntityState $entityState;

    private ?int $id;

    #[Required("El nombre del usuario es requerido")]
    private ?string $name;

    #[Required("El apellido del usuario es requerido")]
    private ?string $lastName;

    #[Required("La fecha de nacimiento es requerida")]
    private ?string $birthDate;

    #[Required("El género es requerido")]
    private ?int $gender;

    #[Required("El correo electrónico es requerido")]
    #[Email("El correo electrónico no tiene el formato correcto")]
    private ?string $email;

    #[Required("La contraseña es requerida")]
    private ?string $password;

    #[Required("La confirmación de la contraseña es requerida")]
    #[EqualTo("password", "La confirmación de contraseña no coincide con la contraseña")]
    private ?string $confirmPassword;

    #[Required("El rol de usuario es requerido")]
    private ?int $userRole;
    
    #[Required("La foto de perfil es requerida")]
    private ?int $profilePicture;

    public function __construct(?array $object = null) {
        $this->userRepository = new UserRepository();
        $this->authRepository = new AuthRepository();

        // foreach ($object as $key => $element) {
        //     //$this->{$key} = $element;
        //     var_dump(property_exists($this, $key));
        // }

        $this->id = $object["id"] ?? null;
        $this->name = $object["name"] ?? null;
        $this->lastName = $object["lastName"] ?? null;
        $this->birthDate = $object["birthDate"] ?? null;
        $this->gender = $object["gender"] ?? null;
        $this->email = $object["email"] ?? null;
        $this->password = $object["password"] ?? null;
        $this->confirmPassword = $object["confirmPassword"] ?? null;
        $this->userRole = $object["userRole"] ?? null;
        $this->profilePicture = $object["profilePicture"] ?? null;

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
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

    public function getGender(): ?int {
        return $this->gender;
    }

    public function setGender(?int $gender): self {
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

    public function getConfirmPassword(): ?string {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(?string $confirmPassword): self {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

    public function getUserRole(): ?int {
        return $this->userRole;
    }

    public function setUserRole(?int $userRole): self {
        $this->userRole = $userRole;
        return $this;
    }

    public function getProfilePicture(): ?int {
        return $this->profilePicture;
    }

    public function setProfilePicture(?int $profilePicture): self {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function save(): bool {
            $user = new User();
            

            $rowsAffected = 0;
            switch ($this->entityState) {
                case EntityState::CREATE: {
                    $user
                        ->setName($this->name)
                        ->setLastName($this->lastName)
                        ->setBirthDate($this->birthDate)
                        ->setGender($this->gender)
                        ->setEmail($this->email)
                        ->setPassword(Crypto::bcrypt($this->password))
                        ->setUserRole($this->userRole)
                        ->setProfilePicture($this->profilePicture);

                    $rowsAffected = $this->userRepository->create($user);
                    break;
                }
                case EntityState::UPDATE: {
                    $user
                        ->setId($this->id)
                        ->setName($this->name)
                        ->setLastName($this->lastName)
                        ->setBirthDate($this->birthDate)
                        ->setGender($this->gender)
                        ->setEmail($this->email)
                        ->setPassword((!is_null($this->password)) ? Crypto::bcrypt($this->password) : $this->password)
                        ->setUserRole($this->userRole)
                        ->setProfilePicture($this->profilePicture);
                    $rowsAffected = $this->userRepository->update($user);
                    break;
                }
            }
            if ($rowsAffected) {
                $this->id = intval(DB::lastInsertId());
            }
            return ($rowsAffected > 0) ? true : false;
        
    }

    public static function findOneById(int $id): ?UserModel {
        $repository = new UserRepository();
        $object = $repository->findOne($id);
        if (!$object) {
            return null;
        }

        return new UserModel($object);
    }

    public function login(): array {
        $user = new User();
        $user->setEmail($this->email);

        return $this->authRepository->login($user);
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}
