<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{
    private array $vehicules = [];
    public function __construct(
        private int $id,
        private string $userEmail
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addVehicule(string $plateNumber): void
    {
        $this->vehicules[] = $plateNumber;
    }

    public function getVehicules(): array
    {
        return $this->vehicules;
    }

    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }
}