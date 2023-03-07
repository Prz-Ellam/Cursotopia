<?php

namespace Cursotopia\Models;

use Bloom\Database\DB;
use Cursotopia\Entities\User;
use Cursotopia\Contracts\UserRepositoryInterface;
use Cursotopia\Repositories\UserRepository;
use Exception;

class UserModel {
    private int $id;
    private string $name;
    private string $lastName;
    private string $birthDate;
    private int $gender;
    private string $email;
    private string $password;
    private int $userRole;
    private int $profilePicture;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate(): string {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): self {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getGender(): int {
        return $this->gender;
    }

    public function setGender(int $gender): self {
        $this->gender = $gender;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self { 
        $this->password = $password;
        return $this;
    }

    public function getUserRole(): int {
        return $this->userRole;
    }

    public function setUserRole(int $userRole): self {
        $this->userRole = $userRole;
        return $this;
    }

    public function getProfilePicture(): int {
        return $this->profilePicture;
    }

    public function setProfilePicture(int $profilePicture): self {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function save(): bool {
        try {
            $user = new User();
            $user
                ->setName($this->name)
                ->setLastName($this->lastName)
                ->setBirthDate($this->birthDate)
                ->setGender($this->gender)
                ->setEmail($this->email)
                ->setPassword($this->password)
                ->setUserRole($this->userRole)
                ->setProfilePicture($this->profilePicture);

            $rowsAffected = $this->userRepository->create($user);
            if ($rowsAffected) {
                $this->id = intval(DB::lastInsertId());
            }
            return ($rowsAffected > 0) ? true : false;
        }
        catch (Exception $exception) {
            return false;
        }
    }
}
