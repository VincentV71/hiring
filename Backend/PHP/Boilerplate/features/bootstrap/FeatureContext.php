<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Fulll\App\Command\AssociateUserAndFleetCommand;
use Fulll\App\Command\AssociateUserAndFleetCommandHandler;
use Fulll\App\Command\AssociateVehiculeAndFleetCommand;
use Fulll\App\Command\AssociateVehiculeAndFleetCommandHandler;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\CreateFleetCommandHandler;
use Fulll\App\Command\CreateUserCommand;
use Fulll\App\Command\CreateUserCommandHandler;
use Fulll\App\Command\CreateVehiculeCommand;
use Fulll\App\Command\CreateVehiculeCommandHandler;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Fulll\Domain\Vehicule;
use Fulll\Infra\Repository\FleetRepository;
use Fulll\Infra\Repository\UserRepository;
use Fulll\Infra\Repository\VehiculeRepository;

class FeatureContext implements Context
{
    private User $appUser;

    private Fleet $appUserFleet;
    private Vehicule $vehicule;

    #[Given('my fleet')]
    public function myFleet(): void
    {
        $userRepository = new UserRepository();
        $handlerUser = new CreateUserCommandHandler($userRepository);
        $user = $handlerUser->handle(new CreateUserCommand('first_user@gmail.com'));

        $fleetRepository = new FleetRepository();
        $handlerFleet = new CreateFleetCommandHandler($fleetRepository);
        $fleet = $handlerFleet->handle(new CreateFleetCommand(1, $user->getEmail()));

        $associateHandler = new AssociateUserAndFleetCommandHandler($userRepository, $fleetRepository);
        $associateHandler->handle(new AssociateUserAndFleetCommand($user, $fleet));
        $this->appUser = $user;
        $this->appUserFleet = $fleet;
    }

    #[Given('a vehicle')]
    public function aVehicle(): void
    {
        $vehiculeHandler = new CreateVehiculeCommandHandler(new VehiculeRepository());
        $this->vehicule = $vehiculeHandler->handle(new CreateVehiculeCommand('1234-FF-13'));
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $vehiculehandler = new AssociateVehiculeAndFleetCommandHandler(
            new VehiculeRepository(),
            new FleetRepository()
        );
        $vehiculehandler->handle(new AssociateVehiculeAndFleetCommand($this->vehicule, $this->appUserFleet));
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $searchedPlateNumber = $this->vehicule->getPlateNumber();

        if(!in_array($searchedPlateNumber, $this->appUserFleet->getVehicules())) {
            throw new Exception(
                sprintf('Le véhicule "%s" ne fait pas partie de la flotte de "%s"', $searchedPlateNumber, $this->appUser->getEmail())
            );
        }
    }
}
