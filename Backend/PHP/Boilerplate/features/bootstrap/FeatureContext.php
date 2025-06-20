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
use Fulll\App\Query\GetVehiculesFromFleetQuery;
use Fulll\App\Query\GetVehiculesFromFleetQueryHandler;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Fulll\Domain\Vehicule;
use Fulll\Domain\VO\Message;
use Fulll\Infra\Repository\FleetRepository;
use Fulll\Infra\Repository\UserRepository;
use Fulll\Infra\Repository\VehiculeRepository;

class FeatureContext implements Context
{
    private User $appUser;
    private Fleet $appUserFleet;
    private Vehicule $vehicule;
    private ?Message $warningMessage = null;

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
        $view = $vehiculehandler->handle(new AssociateVehiculeAndFleetCommand($this->vehicule, $this->appUserFleet));

        if ($view->message) {
            $this->warningMessage = $view->message;
        }
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        if(!$this->thisVehiculeIsPartOfThisFleet($this->vehicule, $this->appUserFleet)) {
            throw new Exception(
                sprintf(
                    'Le véhicule "%s" ne fait pas partie de la flotte de "%s"',
                    $this->vehicule->getPlateNumber(),
                    $this->appUser->getEmail()
                )
            );
        }
    }

    /** register_vehicule : Second scenario */
    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->iRegisterThisVehicleIntoMyFleet();

        if(!$this->thisVehiculeIsPartOfThisFleet($this->vehicule, $this->appUserFleet)) {
            throw new Exception(
                sprintf(
                    'Le véhicule "%s" devrait déjà faire partie de la flotte de "%s"',
                    $this->vehicule->getPlateNumber(),
                    $this->appUser->getEmail()
                )
            );
        }
    }

    private function thisVehiculeIsPartOfThisFleet(Vehicule $vehicule, Fleet $fleet): bool
    {
        $getVehiculesHandler = new GetVehiculesFromFleetQueryHandler(new FleetRepository());
        $fleetVehicules = $getVehiculesHandler->handle(new GetVehiculesFromFleetQuery($fleet));

        return in_array($vehicule->getPlateNumber(), $fleetVehicules);
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        $this->iRegisterThisVehicleIntoMyFleet();
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        if($this->warningMessage->message !== AssociateVehiculeAndFleetCommandHandler::WARNING_MESSAGE) {
            throw new Exception(
                sprintf(
                    'Le message "%s" devrait être affiché',
                    AssociateVehiculeAndFleetCommandHandler::WARNING_MESSAGE
                )
            );
        }
        $this->warningMessage = null;
    }

    /** register_vehicule : Troisième scenario */
    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        $userRepository = new UserRepository();
        $handlerUser = new CreateUserCommandHandler($userRepository);
        $anotherUser = $handlerUser->handle(new CreateUserCommand('another_user@gmail.com'));

        $fleetRepository = new FleetRepository();
        $handlerFleet = new CreateFleetCommandHandler($fleetRepository);
        $anotherFleet = $handlerFleet->handle(new CreateFleetCommand(2, $anotherUser->getEmail()));

        $associateHandler = new AssociateUserAndFleetCommandHandler($userRepository, $fleetRepository);
        $associateHandler->handle(new AssociateUserAndFleetCommand($anotherUser, $anotherFleet));
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        $this->iRegisterThisVehicleIntoMyFleet();
    }
}
