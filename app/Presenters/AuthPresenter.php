<?php declare(strict_types=1);

namespace App\Presenters;

use App\Exception\AuthenticationException;
use App\Model\Auth\Form\LoginFormFactory;
use App\Model\Auth\Form\RegisterFormFactory;
use App\Model\User\UserRepository;
use Nette\Application\UI\Form;

class AuthPresenter extends BasePresenter
{

    public function __construct(
        private readonly LoginFormFactory $loginFormFactory,
        private readonly RegisterFormFactory $registerFormFactory,
        private readonly UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function startup()
    {
        if ($this->getUser()->isLoggedIn() && $this->getAction() !== "logout") {
            $this->flashMessage('Již jste přihlášeni.', 'warning');
            $this->redirect('Homepage:default');
        }

        parent::startup();
    }

    public function actionLogout(): void {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Nejste přihlášeni.', 'warning');
            $this->redirect('Homepage:default');
        }

        $this->getUser()->logout(true);
        $this->flashMessage('Úspěšně odhlášeni.', 'success');
        $this->redirect('Homepage:default');
    }

    public function createComponentLoginForm(): Form
    {
        $form = $this->loginFormFactory->create();

        $form->onSubmit[] = function (Form $form) {
            $values = $form->getValues();
            try {
                $this->getUser()->login($values["username"], $values["password"]);
                $this->redirect("Homepage:default");
            } catch (AuthenticationException $e) {
                $this->flashMessage($e->getMessage(), "danger");
            }
        };

        return $form;
    }

    public function createComponentRegisterForm(): Form
    {
        $form = $this->registerFormFactory->create();

        $form->onSubmit[] = function (Form $form) {
            $values = $form->getValues('array');

            if ($values["password"] !== $values["repeatPassword"]) {
                $this->flashMessage("Hesla se neschodují.");
                return;
            }

            try {
                $this->userRepository->create($values);
                $this->getUser()->login($values["username"], $values["password"]);
                $this->redirect("Homepage:default");
            } catch (AuthenticationException $e) {
                $this->flashMessage($e->getMessage(), "danger");
            }
        };

        return $form;
    }

}