<?php

namespace Fulll\App\Command;

class CreateUserCommand
{
    public function __construct(public string $email)
    {
    }
}