<?php

namespace App\IpLocator\Models\Entities;

use InvalidArgumentException;

readonly class Ip
{
    public function __construct(public string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('IP address cannot be empty');
        }
        
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address');
        }
    }
}