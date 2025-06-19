<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Vehicule
{
    public function __construct(private string $plateNumber)
    {
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}