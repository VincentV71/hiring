<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Vehicule
{
    private array $fleets = [];

    public function __construct(private string $plateNumber)
    {
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function addFleet(int $fleetId): void
    {
        $this->fleets[] = $fleetId;
    }

    public function getFleets(): array
    {
        return $this->fleets;
    }

}