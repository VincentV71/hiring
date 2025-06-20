<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\App\Interface\FleetRepositoryInterface;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Fulll\Domain\Vehicule;

class FleetRepository implements FleetRepositoryInterface
{

    public function createFleet(int $fleetId, string $email): Fleet
    {
        return new Fleet($fleetId, $email);
    }

    public function associateFleetWithUser(Fleet $fleet, User $user): Fleet
    {
        $fleet->setUserEmail($user->getEmail());

        return $fleet;
    }

    public function associateFleetWithVehicule(Fleet $fleet, Vehicule $vehicule): Fleet
    {
        $fleet->addVehicule($vehicule->getPlateNumber());

        return $fleet;
    }
}