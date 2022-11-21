<?php declare(strict_types=1);

namespace App\Model\Post;

use DateTime;

class Post
{

  public const TABLE_NAME = "posts";

  public const ID_FIELD = "id";

  public const TITLE_FIELD = "title";

  public const PEREX_FIELD = "perex";

  public const CONTENT_FIELD = "content";

  public const CREATED_AT_FIELD = "created_at";

  public function __construct(
    private readonly int $id,
    private string $title,
    private string $perex,
    private string $content,
    private readonly DateTime $createdAt = new DateTime()
  )
  {
  }

  /**
   * Create an instance from an array.
   *
   * @param array<string, mixed> $data
   * @return Post
   */
  public static function fill(array $data): Post
  {
    return new Post(
      $data[self::ID_FIELD],
      $data[self::TITLE_FIELD],
      $data[self::PEREX_FIELD],
      $data[self::CONTENT_FIELD],
      $data[self::CREATED_AT_FIELD]
    );
  }

  public function __toString(): string
  {
    return $this->getTitle();
  }

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
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
      self::TITLE_FIELD => $this->getTitle(),
      self::PEREX_FIELD => $this->getPerex(),
      self::CONTENT_FIELD => $this->getContent(),
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
  public function getPerex(): string
  {
    return $this->perex;
  }

  /**
   * @return string
   */
  public function getContent(): string
  {
    return $this->content;
  }

  /**
   * @return DateTime
   */
  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }

  /**
   * @param string $title
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  /**
   * @param string $perex
   */
  public function setPerex(string $perex): void
  {
    $this->perex = $perex;
  }

  /**
   * @param string $content
   */
  public function setContent(string $content): void
  {
    $this->content = $content;
  }

}
