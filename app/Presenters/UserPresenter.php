<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Security\Passwords;
use App\Model\User\Form\PasswordFormFactory;
use App\Model\User\UserRepository;
use Nette\Application\UI\Form;

class UserPresenter extends BasePresenter
{

  public function __construct(
    private readonly PasswordFormFactory $passwordFormFactory,
    private readonly Passwords $passwords,
    private readonly UserRepository $userRepository,
  )
  {
    parent::__construct();
  }

  public function createComponentPasswordForm(): Form
  {
    $form = $this->passwordFormFactory->create();

    $form->onSuccess[] = function (Form $form) {
      $values = $form->getValues();

      if ($values["newPassword"] !== $values["newPasswordRepeat"]) {
        $this->flashMessage('Nová hesla se neshodují.', 'danger');
        return;
      }

      $oldHash = $this->getUser()->getIdentity()?->getData()['password'];

      if (!$this->passwords->verify($values["oldPassword"], $oldHash)) {
        $this->flashMessage('Staré heslo je nesprávné.', 'danger');
        return;
      }

      $this->userRepository->changePassword($this->getUser()->getId(), $values["newPassword"]);

      $this->flashMessage('Heslo změněno.', 'info');
    };

    return $form;
  }

}
