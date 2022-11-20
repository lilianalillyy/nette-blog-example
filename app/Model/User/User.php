<?php declare(strict_types=1);

namespace App\Model\User;

use DateTime;
use RuntimeException;

class User
{

    public const TABLE_NAME = "users";

    public const ID_FIELD = "id";

    public const USERNAME_FIELD = "username";

    public const PASSWORD_FIELD = "password";

    public const CREATED_AT_FIELD = "created_at";

    public const UPDATED_AT_FIELD = "updated_at";

    public function __construct(
        private readonly int $id,
        private string $username,
        private string $passwordHash,
        private DateTime $updatedAt,
        private readonly DateTime $createdAt,
    )
    {
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    public static function fill(array $data): User
    {
        return new User(
            $data[self::ID_FIELD],
            $data[self::USERNAME_FIELD],
            $data[self::PASSWORD_FIELD],
            $data[self::UPDATED_AT_FIELD],
            $data[self::CREATED_AT_FIELD]
        );
    }

    public function toArray(): array
    {
        return [
            self::ID_FIELD => $this->getId(),
            self::USERNAME_FIELD => $this->getUsername(),
            self::PASSWORD_FIELD => $this->getPasswordHash(),
            self::UPDATED_AT_FIELD => $this->getUpdatedAt(),
            self::CREATED_AT_FIELD => $this->getCreatedAt()
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash(string $passwordHash): static
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt(DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}