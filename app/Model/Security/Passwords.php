<?php declare(strict_types=1);

namespace App\Model\Security;

use Nette\Security\Passwords as NettePasswords;

class Passwords extends NettePasswords
{

    public function __construct($algo = PASSWORD_ARGON2ID, array $options = [])
    {
        parent::__construct($algo, $options);
    }

}