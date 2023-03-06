<?php

namespace Cursotopia\entities;

class User {
    private int $id;
    private string $name;
    private string $lastName;
    private string $birthDate;
    private int $gender;
    private string $email;
    private string $password;
    private int $userRole;
    private int $profilePicture;
    private bool $enabled;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getBirthDate(): string {
        return $this->birthDate;
    }

    public function getGender(): int {
        return $this->gender;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getUserRole(): int {
        return $this->userRole;
    }

    public function getProfilePicture(): int {
        return $this->profilePicture;
    }

    public function getEnabled(): bool {
        return $this->enabled;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getModifiedAt(): string {
        return $this->modifiedAt;
    }

    public function getAction(): bool {
        return $this->active;
    }
}
