<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class CreateUserCommand
{
    public function __construct(public string $email)
    {
    }
}