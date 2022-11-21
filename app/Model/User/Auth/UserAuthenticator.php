<?php declare(strict_types=1);

namespace App\Model\User\Auth;

use App\Exception\AuthenticationException;
use App\Model\Security\Passwords;
use App\Model\User\UserRepository;
use Nette\Security\Authenticator;
use Nette\Security\IdentityHandler;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;

class UserAuthenticator implements Authenticator, IdentityHandler
{

  public function __construct(
    private readonly UserRepository $userRepository,
    private readonly Passwords $passwords
  )
  {
  }

  public function authenticate(string $user, string $password): SimpleIdentity
  {
    $entity = $this->userRepository->findOne(["username" => $user]);

    if (!$entity || !$this->passwords->verify($password, $entity->getPasswordHash())) {
      throw new AuthenticationException("Uživatelské jméno nebo heslo je nesprávné.");
    }

    return new SimpleIdentity($entity->getId(), null, $entity->toArray());
  }

  public function sleepIdentity(IIdentity $identity): IIdentity
  {
    return $identity;
  }

  /**
   * @param SimpleIdentity $identity
   * @return IIdentity|null
   */
  public function wakeupIdentity(IIdentity $identity): ?IIdentity
  {
    $user = $this->userRepository->findById($identity->getId());

    if (!$user) {
      return null;
    }

    return new SimpleIdentity($user->getId(), null, $user->toArray());
  }

}
