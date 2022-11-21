<?php declare(strict_types=1);

namespace App\Model\Rating;

use App\Model\User\User;
use DateTime;

class Rating
{

    public const TABLE_NAME = "ratings";

    public const ID_FIELD = "id";

    public const KIND_FIELD = "kind";

    public const POST_ID_FIELD = "post_id";

    public const USER_ID_FIELD = "user_id";

    public const CREATED_AT_FIELD = "created_at";

    public const UPDATED_AT_FIELD = "updated_at";

    public const KIND_LIKE = "like";

    public const KIND_DISLIKE = "dislike";

    public function __construct(
        private readonly int $id,
        private string $kind,
        private readonly int $postId,
        private readonly int $userId,
        private DateTime $updatedAt,
        private readonly DateTime $createdAt = new DateTime(),
    )
    {
    }

    public function __toString(): string
    {
        return $this->getKind();
    }

    /**
     * Create an instance from an array.
     *
     * @param array<string, mixed> $data
     * @return Rating
     */
    public static function fill(array $data): Rating
    {
        return new Rating(
            $data[self::ID_FIELD],
            $data[self::KIND_FIELD],
            $data[self::POST_ID_FIELD],
            $data[self::USER_ID_FIELD],
            $data[self::UPDATED_AT_FIELD],
            $data[self::CREATED_AT_FIELD]
        );
    }

    /**
     * Transform an instance into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            self::ID_FIELD => $this->getId(),
            self::KIND_FIELD => $this->getKind(),
            self::POST_ID_FIELD => $this->getPostId(),
            self::USER_ID_FIELD => $this->getUserId(),
            self::CREATED_AT_FIELD => $this->getCreatedAt(),
            self::UPDATED_AT_FIELD => $this->getUpdatedAt()
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
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getKind(): string
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     */
    public function setKind(string $kind): void
    {
        $this->kind = $kind;
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
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}