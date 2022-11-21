<?php declare(strict_types=1);

namespace App\Model\Post;

use DateTime;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class PostRepository
{

    public function __construct(
        private readonly Explorer $db,
    )
    {
    }

    /**
     * Get table of posts.
     *
     * @return Selection
     */
    public function getDatabase(): Selection
    {
        return $this->db->table(Post::TABLE_NAME);
    }

    /**
     * Find post by primary key.
     *
     * @param int $id
     * @return Post|null
     */
    public function findById(int $id): ?Post {
        $row = $this->getDatabase()->get($id);

        return $row ? Post::fill($row->toArray()) : null;
    }

    /**
     * Find first post by matching conditions.
     *
     * @param array<string, mixed> $conditions
     * @return Post|null
     */
    public function findOne(array $conditions = []): ?Post {
        $row = $this->getDatabase()->where($conditions)->fetch();

        return $row ? Post::fill($row->toArray()) : null;
    }

    /**
     * Find multiple posts.
     *
     * @param array<string, mixed> $conditions
     * @param string $order
     * @return Post[]
     */
    public function findMany(array $conditions = [], string $order = ""): array
    {
        $query = $this->getDatabase()->where($conditions);

        if ($order) {
            $query->order($order);
        }

        $rows = $query->fetchAll();

        return array_map(fn (ActiveRow $row) => Post::fill($row->toArray()), $rows);
    }

    /**
     * Create a new post.
     *
     * @param array<string, mixed> $data
     * @return Post
     */
    public function create(array $data): Post
    {
        /** @var ActiveRow $row */
        $row = $this->getDatabase()->insert([
            Post::TITLE_FIELD => $data["title"],
            Post::PEREX_FIELD => $data["perex"],
            Post::CONTENT_FIELD => $data["content"],
            Post::CREATED_AT_FIELD => new DateTime()
        ]);

        return Post::fill($row->toArray());
    }

}