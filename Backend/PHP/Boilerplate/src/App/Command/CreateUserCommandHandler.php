<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\UserRepositoryInterface;
use Fulll\Domain\User;

class CreateUserCommandHandler
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(CreateUserCommand $command): User
    {
        return $this->repository->createUser($command->email);
    }
}