<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
      if (!$user instanceof AppUser) {
        return;
      }

      if ($user->isBlocked()){
        throw new DisabledException('User account is disabled.');
      }

      return;
    }

    public function checkPostAuth(UserInterface $user): void{
    }
}

?>
