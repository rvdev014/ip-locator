<?php

namespace App\IpLocator\Interfaces;

use App\IpLocator\Models\Ip;
use App\IpLocator\Models\Location;

interface Locator
{
    public function locate(Ip $ip): ?Location;
}