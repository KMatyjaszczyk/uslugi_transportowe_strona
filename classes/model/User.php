<?php
class User {
    protected ?int $id;
    protected string $login;
    protected string $password;
    protected string $email;
    protected bool $isAdmin;
    protected DateTime $creationDate;

    public function __construct(?int $id, string $login, string $password, string $email, bool $isAdmin = false, DateTime $creationDate) {
        $this->id = $id;
        $this->login = $login;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->email = $email;
        $this->isAdmin = $isAdmin;
        $this->creationDate = $creationDate;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getIsAdmin(): bool {
        return $this->isAdmin;
    }

    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }
}