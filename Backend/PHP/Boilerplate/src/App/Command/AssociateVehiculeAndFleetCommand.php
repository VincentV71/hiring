<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicule;

class AssociateVehiculeAndFleetCommand
{
    public function __construct(
        public Vehicule $vehicule,
        public Fleet $fleet
    ) {
    }
}