<?php

namespace App\IpLocator;

use App\IpLocator\Interfaces\Locator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Models\Entities\Location;
use App\IpLocator\Services\Cache;

class CacheLocator implements Locator
{
    public function __construct(
        protected Locator $next,
        protected Cache $cache,
        protected string $prefix,
        protected int $ttl
    ) {
    }

    public function locate(Ip $ip): ?Location
    {
        $cacheKey = "$this->prefix-location-$ip->value";
        $location = $this->cache->get($cacheKey);

        if ($location === null) {
            $location = $this->next->locate($ip);
            $this->cache->set($cacheKey, $location, $this->ttl);
        }

        return $location;
    }
}