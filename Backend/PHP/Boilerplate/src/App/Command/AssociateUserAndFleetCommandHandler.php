<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepositoryInterface;
use Fulll\App\Interface\UserRepositoryInterface;

class AssociateUserAndFleetCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private FleetRepositoryInterface $fleetRepository
    ) {
    }

    public function handle(AssociateUserAndFleetCommand $command): void
    {
        // TODO : make a transactionnal commit or rollback all insertions
        $this->userRepository->associateUserWithFleet(
            $command->user,
            $command->fleet
        );

        $this->fleetRepository->associateFleetWithUser(
            $command->fleet,
            $command->user
        );
    }
}