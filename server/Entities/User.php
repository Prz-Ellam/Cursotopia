<?php

namespace Cursotopia\Entities;

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

    public function getEnabled(): bool {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self {
        $this->enabled = $enabled;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): string {
        return $this->modifiedAt;
    }

    public function setModifiedAt(string $modifiedAt): self {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getActive(): bool {
        return $this->active;
    }

    public function setActive(bool $active): self {
        $this->active = $active;
        return $this;
    }
}
