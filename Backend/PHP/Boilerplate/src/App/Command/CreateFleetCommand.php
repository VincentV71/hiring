<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class CreateFleetCommand
{
    public function __construct(public int $fleetId, public string $userEmail)
    {
    }
}