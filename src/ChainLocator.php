<?php

namespace App\IpLocator;

use Throwable;
use App\IpLocator\Interfaces\Locator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Handlers\ErrorHandler;
use App\IpLocator\Models\Entities\Location;

class ChainLocator implements Locator
{
    protected array $locators = [];
    
    public function __construct(Locator ...$locators)
    {
        $this->locators = $locators;
    }
    
    public function locate(Ip $ip): ?Location
    {
        foreach ($this->locators as $locator) {
            $result = $locator->locate($ip);
            if ($result !== null) {
                return $result;
            }
        }
        
        return null;
    }
}