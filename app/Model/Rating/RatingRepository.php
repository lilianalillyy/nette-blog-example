<?php declare(strict_types=1);

namespace App\Model\Rating;

use App\Exception\EntityNotFoundException;
use App\Exception\InvalidArgumentException;
use App\Model\Post\PostRepository;
use App\Model\User\UserRepository;
use DateTime;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class RatingRepository
{

    public function __construct(
        private readonly Explorer $db,
        private readonly PostRepository $postRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * Get table of ratings.
     *
     * @return Selection
     */
    public function getDatabase(): Selection
    {
        return $this->db->table(Rating::TABLE_NAME);
    }

    /**
     * Find rating by primary key.
     *
     * @param int $id
     * @return Rating|null
     */
    public function findById(int $id): ?Rating
    {
        $row = $this->getDatabase()->get($id);

        return $row ? Rating::fill($row->toArray()) : null;
    }

    /**
     * Find first rating by matching conditions.
     *
     * @param array<string, mixed> $conditions
     * @return Rating|null
     */
    public function findOne(array $conditions = []): ?Rating
    {
        $row = $this->getDatabase()->where($conditions)->fetch();

        return $row ? Rating::fill($row->toArray()) : null;
    }

    /**
     * Find multiple ratings.
     *
     * @param array<string, mixed> $conditions
     * @param string|null $order
     * @return Rating[]
     */
    public function findMany(array $conditions = [], ?string $order = null): array
    {
        $query = $this->getDatabase()->where($conditions);

        if ($order) {
            $query->order($order);
        }

        $rows = $query->fetchAll();

        return array_map(fn(ActiveRow $row) => Rating::fill($row->toArray()), $rows);
    }

    /**
     * Create a new rating.
     *
     * @param array<string, mixed> $data
     * @param int $postId
     * @param int $userId
     * @return Rating
     */
    public function create(array $data, int $postId, int $userId): Rating
    {
        /** @var ActiveRow $row */
        $row = $this->getDatabase()->insert([
            Rating::KIND_FIELD => $data["kind"],
            Rating::POST_ID_FIELD => $postId,
            Rating::USER_ID_FIELD => $userId,
            Rating::CREATED_AT_FIELD => new DateTime(),
            Rating::UPDATED_AT_FIELD => new DateTime(),
        ]);

        return Rating::fill($row->toArray());

    }

    public function countRatings(int $postId, ?string $kind = Rating::KIND_LIKE): int
    {
        return $this->getDatabase()->where(array_merge([
            Rating::POST_ID_FIELD => $postId
        ], $kind ? [Rating::KIND_FIELD => $kind] : []))->count();
    }

    public function ratePost(int $postId, int $userId, string $kind): ?Rating
    {
        if (!in_array($kind, [Rating::KIND_LIKE, Rating::KIND_DISLIKE])) {
            throw new InvalidArgumentException("Neplatné hodnocení.");
        }

        $post = $this->postRepository->findById($postId);

        if (!$post) {
            throw new EntityNotFoundException("Příspěvek nenalezen.");
        }

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new EntityNotFoundException("Uživatel nenalezen.");
        }

        /** @var ActiveRow|null $rating */
        $rating = $this->getDatabase()->where([
            Rating::POST_ID_FIELD => $post->getId(),
            Rating::USER_ID_FIELD => $user->getId()
        ])->fetch();

        if (!$rating) {
            /** @var ActiveRow $rating */
            $rating = $this->getDatabase()->insert([
                Rating::KIND_FIELD => $kind,
                Rating::POST_ID_FIELD => $postId,
                Rating::USER_ID_FIELD => $userId,
                Rating::CREATED_AT_FIELD => new DateTime()
            ]);
        } else {
            if ($rating->kind === $kind) {
                $rating->delete();
                return null;
            }

            $rating->update([
                Rating::KIND_FIELD => $kind,
                Rating::UPDATED_AT_FIELD => new DateTime()
            ]);
        }


        return Rating::fill($rating->toArray());
    }

}