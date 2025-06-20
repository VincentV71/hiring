<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepositoryInterface;
use Fulll\Domain\Fleet;

class CreateFleetCommandHandler
{
    public function __construct(private FleetRepositoryInterface $repository)
    {
    }

    public function handle(CreateFleetCommand $command): Fleet
    {
        return $this->repository->createFleet(
            $command->fleetId,
            $command->userEmail
        );
    }
}