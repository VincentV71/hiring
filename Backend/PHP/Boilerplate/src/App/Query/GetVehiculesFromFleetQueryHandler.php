<?php

namespace Fulll\App\Query;

use Fulll\App\Interface\FleetRepositoryInterface;

class GetVehiculesFromFleetQueryHandler
{
    public function __construct(private FleetRepositoryInterface $fleetRepository)
    {
    }

    public function handle(GetVehiculesFromFleetQuery $query): array
    {
        return $this->fleetRepository->getVehicules($query->fleet);
    }
}