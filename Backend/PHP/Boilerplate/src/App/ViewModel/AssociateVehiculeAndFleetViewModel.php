<?php

namespace Fulll\App\ViewModel;

use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicule;
use Fulll\Domain\VO\Message;

class AssociateVehiculeAndFleetViewModel
{
    public function __construct(
        public Vehicule $vehicule,
        public Fleet $fleet,
        public ?Message $message
    ) {
    }
}