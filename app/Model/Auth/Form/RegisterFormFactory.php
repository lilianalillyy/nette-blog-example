<?php declare(strict_types=1);

namespace App\Model\Auth\Form;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;

class RegisterFormFactory
{

    public function create(): Form
    {
        $form = new BootstrapForm();

        $form->setAjax();

        $form->renderMode = RenderMode::SIDE_BY_SIDE_MODE;

        $form->addText('username', 'Uživatelské jméno')
            ->setMaxLength(32)
            ->setRequired();

        $form->addPassword('password', 'Heslo')
            ->setRequired();

        $form->addPassword('repeatPassword', 'Heslo znovu')
            ->setRequired();

        $form->addSubmit('submit', 'Registrovat se');

        return $form;
    }

}