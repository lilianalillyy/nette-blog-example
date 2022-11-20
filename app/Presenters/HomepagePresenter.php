<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Post\PostRepository;

final class HomepagePresenter extends BasePresenter
{

    public function __construct(
        private readonly PostRepository $postRepository
    )
    {
        parent::__construct();
    }

    public function renderDefault() {
        $posts = $this->postRepository->findMany(order: "created_at DESC");
        $latestPost = count($posts) ? current($posts) : null;

        $this->template->latestPost = $latestPost;
        $this->template->posts = $posts;
    }

}
