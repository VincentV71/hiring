<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicule;

interface VehiculeRepositoryInterface
{
    public function createVehicule(string $plateNumber): Vehicule;

    public function associateVehiculeWithFleet(Vehicule $vehicule, Fleet $fleet): Vehicule;
}