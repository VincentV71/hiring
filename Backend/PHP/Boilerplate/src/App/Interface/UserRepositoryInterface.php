<?php

namespace Fulll\App\Interface;

use Fulll\Domain\User;

interface UserRepositoryInterface
{
    public function addUser(string $email): User;
}