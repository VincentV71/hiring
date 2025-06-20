<?php

declare(strict_types=1);

namespace Fulll\Domain;

class User
{
    private ?int $fleetId;
    public function __construct(private string $email)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFleetId(): ?int
    {
        return $this->fleetId;
    }

    public function setFleetId(int $fleetId): void
    {
        $this->fleetId = $fleetId;
    }
}