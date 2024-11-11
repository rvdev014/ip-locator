<?php

namespace App\IpLocator\Models;

use InvalidArgumentException;

readonly class Ip
{
    public function __construct(public string $ip)
    {
        if (empty($ip)) {
            throw new InvalidArgumentException('IP address cannot be empty');
        }
        
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address');
        }
    }
}