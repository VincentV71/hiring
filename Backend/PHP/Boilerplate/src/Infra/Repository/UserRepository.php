<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\App\Interface\UserRepositoryInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;

class UserRepository implements UserRepositoryInterface
{

    public function createUser(string $email): User
    {
        return new User($email);
    }

    public function associateUserWithFleet(User $user, Fleet $fleet): User
    {
        $user->setFleetId($fleet->getId());

        return $user;
    }
}