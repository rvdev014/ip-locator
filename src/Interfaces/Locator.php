<?php

namespace App\IpLocator\Interfaces;

use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Models\Entities\Location;

interface Locator
{
    public function locate(Ip $ip): ?Location;
}