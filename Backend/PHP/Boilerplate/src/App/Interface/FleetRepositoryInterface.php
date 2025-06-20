<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Fulll\Domain\Vehicule;

interface FleetRepositoryInterface
{
    public function createFleet(int $fleetId, string $email): Fleet;
    public function associateFleetWithUser(Fleet $fleet, User $user): Fleet;

    public function associateFleetWithVehicule(Fleet $fleet, Vehicule $vehicule): Fleet;
}