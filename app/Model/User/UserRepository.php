<?php declare(strict_types=1);

namespace App\Model\User;

use App\Exception\EntityNotFoundException;
use App\Model\Security\Passwords;
use DateTime;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class UserRepository
{

    public function __construct(
        private readonly Explorer $db,
        private readonly Passwords $passwords
    )
    {
    }

    /**
     * Get table of users.
     *
     * @return Selection
     */
    public function getDatabase(): Selection
    {
        return $this->db->table(User::TABLE_NAME);
    }

    /**
     * Find user by primary key.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User {
        $row = $this->getDatabase()->get($id);

        return $row ? User::fill($row->toArray()) : null;
    }

    /**
     * Find first user by matching conditions.
     *
     * @param array $conditions
     * @return User|null
     */
    public function findOne(array $conditions = []): ?User {
        $row = $this->getDatabase()->where($conditions)->fetch();

        return $row ? User::fill($row->toArray()) : null;
    }

    /**
     * Find multiple users.
     *
     * @param array $conditions
     * @param string $order
     * @return array
     */
    public function findMany(array $conditions = [], string $order = ""): array
    {
        $query = $this->getDatabase()->where($conditions);

        if ($order) {
            $query->order($order);
        }

        $rows = $query->fetchAll();

        return array_map(fn (ActiveRow $row) => User::fill($row->toArray()), $rows);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $row = $this->getDatabase()->insert([
            User::USERNAME_FIELD => $data["username"],
            User::PASSWORD_FIELD => $this->passwords->hash($data["password"]),
            User::UPDATED_AT_FIELD => new DateTime(),
            User::CREATED_AT_FIELD => new DateTime()
        ]);

        return User::fill($row->toArray());
    }

    /**
     * Change user's password.
     *
     * @param int $id
     * @param string $password
     * @return User
     */
    public function changePassword(int $id, string $password): User {
        $row = $this->getDatabase()->get($id);

        if (!$row) {
            throw new EntityNotFoundException();
        }

        $row->update([
            User::PASSWORD_FIELD => $this->passwords->hash($password),
            User::UPDATED_AT_FIELD => new DateTime()
        ]);

        return User::fill($row->toArray());
    }

}