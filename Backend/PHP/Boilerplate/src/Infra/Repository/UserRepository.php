<?php

namespace Fulll\Infra\Repository;

use Fulll\App\Interface\UserRepositoryInterface;
use Fulll\Domain\User;

class UserRepository implements UserRepositoryInterface
{

    public function addUser(string $email): User
    {
        return new User($email);
    }
}