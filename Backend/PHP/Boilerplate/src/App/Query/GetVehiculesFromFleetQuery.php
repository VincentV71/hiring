<?php

namespace Fulll\App\Query;

use Fulll\Domain\Fleet;

class GetVehiculesFromFleetQuery
{
    public function __construct(public Fleet $fleet)
    {
    }
}