<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Fulll\App\Command\CreateUserCommand;
use Fulll\App\Command\CreateUserCommandHandler;
use Fulll\Domain\Fleet;
use Fulll\Domain\User;
use Fulll\Domain\Vehicule;
use Fulll\Infra\Repository\UserRepository;

class FeatureContext implements Context
{
    private User $appUser;
    private Vehicule $vehicule;

    #[Given('my fleet')]
    public function myFleet(): void
    {
        $handlerUser = new CreateUserCommandHandler(new UserRepository());
        $user = $handlerUser->handle(new CreateUserCommand('first_user@gmail.com'));

        $fleet = new Fleet($user->getEmail());
        $user->setFleet($fleet);
        $this->appUser = $user;
    }

    #[Given('a vehicle')]
    public function aVehicle(): void
    {
        $this->vehicule = new Vehicule("1234-FF-13");
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $this->appUser->getFleet()->addVehicule(
            $this->vehicule
        );
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $plateNumbers = [];
        foreach ($this->appUser->getFleet()->getVehicules() as $vehicule) {
            $plateNumbers[] = $vehicule->getPlateNumber();
        }

        $searchedPlateNumber = $this->vehicule->getPlateNumber();

        if(!in_array($searchedPlateNumber, $plateNumbers)) {
            throw new Exception(
                sprintf('Le véhicule %s ne fait pas partie de votre flotte', $searchedPlateNumber)
            );
        }
    }

}
