<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Fleet;
use Fulll\Domain\User;

interface UserRepositoryInterface
{
    public function createUser(string $email): User;

    public function associateUserWithFleet(User $user, Fleet $fleet): User;
}