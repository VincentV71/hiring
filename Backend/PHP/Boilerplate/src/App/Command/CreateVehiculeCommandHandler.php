<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\VehiculeRepositoryInterface;
use Fulll\Domain\Vehicule;

class CreateVehiculeCommandHandler
{
    public function __construct(private VehiculeRepositoryInterface $repository)
    {
    }

    public function handle(CreateVehiculeCommand $command): Vehicule
    {
        return $this->repository->createVehicule($command->plateNumber);
    }
}