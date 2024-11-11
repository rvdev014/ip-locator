<?php

namespace App\IpLocator\Models;

readonly class Location
{
    public function __construct(
        public string $city,
        public string $region,
        public string $country
    ) {}
}