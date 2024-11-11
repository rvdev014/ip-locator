<?php

namespace App\IpLocator;

use Throwable;
use App\IpLocator\Interfaces\Locator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Handlers\ErrorHandler;
use App\IpLocator\Models\Entities\Location;

class MuteLocator implements Locator
{
    public function __construct(
        protected Locator $next,
        protected ErrorHandler $errorHandler
    )
    {}
    
    public function locate(Ip $ip): ?Location
    {
        try {
            return $this->next->locate($ip);
        } catch (Throwable $e) {
            $this->errorHandler->handle($e);
            return null;
        }
    }
}