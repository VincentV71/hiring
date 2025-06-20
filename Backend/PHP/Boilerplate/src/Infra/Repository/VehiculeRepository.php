<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\App\Interface\VehiculeRepositoryInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicule;

class VehiculeRepository implements VehiculeRepositoryInterface
{
    public function createVehicule(string $plateNumber): Vehicule
    {
        return new Vehicule($plateNumber);
    }

    public function associateVehiculeWithFleet(Vehicule $vehicule, Fleet $fleet): ?Vehicule
    {
        if(in_array($vehicule->getPlateNumber(), $fleet->getVehicules())) {
            return null;
        };

        $vehicule->addFleet($fleet->getId());

        return $vehicule;
    }
}