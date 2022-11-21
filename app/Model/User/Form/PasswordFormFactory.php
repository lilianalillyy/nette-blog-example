<?php declare(strict_types=1);

namespace App\Model\User\Form;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;

class PasswordFormFactory
{

    public function create(): Form
    {
        $form = new BootstrapForm();

        $form->setAjax();

        $form->renderMode = RenderMode::SIDE_BY_SIDE_MODE;

        $form->addPassword('oldPassword', 'Staré heslo')->setRequired();

        $form->addPassword('newPassword', 'Nové heslo')->setRequired();

        $form->addPassword('newPasswordRepeat', 'Nové heslo znovu')->setRequired();

        $form->addSubmit('submit', "Změnit heslo");

        return $form;
    }

}