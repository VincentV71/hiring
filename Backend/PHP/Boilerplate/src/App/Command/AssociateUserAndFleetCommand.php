<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Fleet;
use Fulll\Domain\User;

class AssociateUserAndFleetCommand
{
    public function __construct(
        public User $user,
        public Fleet $fleet
    ) {
    }
}