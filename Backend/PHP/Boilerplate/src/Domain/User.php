<?php

declare(strict_types=1);

namespace Fulll\Domain;

class User
{
    private ?Fleet $fleet;
    public function __construct(private string $email)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }
}