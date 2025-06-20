<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class CreateVehiculeCommand
{
    public function __construct(public string $plateNumber)
    {
    }
}