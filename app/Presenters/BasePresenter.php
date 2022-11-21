<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{

  protected function startup()
  {
    $this->redrawControl("title");
    $this->redrawControl("content");

    parent::startup();
  }

}
