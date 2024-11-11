<?php

namespace App\IpLocator\Models\Entities;

readonly class Location
{
    public function __construct(
        public string $country,
        public ?string $city,
        public ?string $region,
    ) {}
}