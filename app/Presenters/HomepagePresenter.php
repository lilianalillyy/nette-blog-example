<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Post\Post;
use App\Model\Post\PostRepository;
use App\Model\Rating\RatingRepository;
use Nette\Database\Table\ActiveRow;

final class HomepagePresenter extends BasePresenter
{

  public function __construct(
    private readonly PostRepository $postRepository,
    private readonly RatingRepository $ratingRepository,
  )
  {
    parent::__construct();
  }

  public function renderDefault(int $page = 1, string $sortBy = 'created_at'): void
  {
    $orderColumn = match ($sortBy) {
      'created_at' => Post::CREATED_AT_FIELD,
      'title' => Post::TITLE_FIELD,
      'rating' => null,
      default => Post::CREATED_AT_FIELD
    };
    $lastPage = 0;

    // Not using findMany() because of pagination
    $query = $this->postRepository->getDatabase();

    if ($orderColumn) {
      $query->order("$orderColumn DESC");
    }

    $posts = $query->page($page, 5, $lastPage)->fetchAll();

    if ($sortBy === 'rating') {
      usort($posts, fn($a, $b) => $this->ratingRepository->countRatings($b['id']) <=> $this->ratingRepository->countRatings($a['id']));
    }

    bdump($posts);

    $posts = array_map(fn(ActiveRow $row) => Post::fill($row->toArray()), $posts);

    $this->template->latestPost = count($posts) ? current($posts) : null;
    $this->template->posts = $posts;

    $this->template->page = $page;
    $this->template->lastPage = $lastPage;
  }

}
