<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{
    private array $vehicules = [];
    public function __construct(private string $userEmail)
    {
    }

    public function addVehicule(Vehicule $vehicule): void
    {
        $this->vehicules[] = $vehicule;
    }

    public function getVehicules(): array
    {
        return $this->vehicules;
    }
}