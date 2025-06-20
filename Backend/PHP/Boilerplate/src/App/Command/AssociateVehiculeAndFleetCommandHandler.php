<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepositoryInterface;
use Fulll\App\Interface\VehiculeRepositoryInterface;
use Fulll\App\ViewModel\AssociateVehiculeAndFleetViewModel;
use Fulll\Domain\VO\Message;

class AssociateVehiculeAndFleetCommandHandler
{
    public const WARNING_MESSAGE = 'Ce véhicule existe déjà dans cette flotte.';

    public function __construct(
        private VehiculeRepositoryInterface $vehiculeRepository,
        private FleetRepositoryInterface $fleetRepository
    ) {
    }

    public function handle(AssociateVehiculeAndFleetCommand $command): AssociateVehiculeAndFleetViewModel
    {
        // TODO : make a transactionnal commit or rollback all insertions
        $vehicule = $this->vehiculeRepository->associateVehiculeWithFleet(
            $command->vehicule,
            $command->fleet
        );

        if(!$vehicule) {
            return new AssociateVehiculeAndFleetViewModel(
                $command->vehicule,
                $command->fleet,
                new Message(self::WARNING_MESSAGE)
            );
        }

        $fleet = $this->fleetRepository->associateFleetWithVehicule(
            $command->fleet,
            $command->vehicule
        );

        return new AssociateVehiculeAndFleetViewModel(
            $vehicule,
            $fleet,
            null
        );
    }
}