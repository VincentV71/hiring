<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepositoryInterface;
use Fulll\App\Interface\VehiculeRepositoryInterface;

class AssociateVehiculeAndFleetCommandHandler
{
    public function __construct(
        private VehiculeRepositoryInterface $vehiculeRepository,
        private FleetRepositoryInterface $fleetRepository
    ) {
    }

    public function handle(AssociateVehiculeAndFleetCommand $command): void
    {
        // TODO : make a transactionnal commit or rollback all insertions
        $this->vehiculeRepository->associateVehiculeWithFleet(
            $command->vehicule,
            $command->fleet
        );

        $this->fleetRepository->associateFleetWithVehicule(
            $command->fleet,
            $command->vehicule
        );
    }
}