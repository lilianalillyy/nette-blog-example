<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Post\PostRepository;
use App\Model\Rating\Rating;
use App\Model\Rating\RatingRepository;

class PostPresenter extends BasePresenter
{

    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly RatingRepository $ratingRepository
    )
    {
        parent::__construct();
    }

    protected function startup()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Nejste přihlášeni.", "danger");
            $this->redirect("Auth:login");
        }

        parent::startup();
    }

    public function renderView(int $id)
    {
        $post = $this->postRepository->findById($id);

        if (!$post) {
            $this->error();
        }

        $this->template->post = $post;

        $ratings = $this->ratingRepository->findMany([Rating::POST_ID_FIELD => $post->getId()]);

        $this->template->likes = count(array_filter($ratings, fn(Rating $rating) => $rating->getKind() === Rating::KIND_LIKE));
        $this->template->dislikes = count(array_filter($ratings, fn(Rating $rating) => $rating->getKind() === Rating::KIND_DISLIKE));
    }

    public function handleLike(int $id)
    {
        $this->ratingRepository->ratePost($id, $this->getUser()->getId(), Rating::KIND_LIKE);

        $this->redirect(":view", ["id" => $id]);
    }

    public function handleDislike(int $id)
    {
        $this->ratingRepository->ratePost($id, $this->getUser()->getId(), Rating::KIND_DISLIKE);

        $this->redirect(":view", ["id" => $id]);
    }

}