<?php

namespace App\IpLocator;

use Exception;
use App\IpLocator\Models\Ip;
use App\IpLocator\Models\HttpClient;
use App\IpLocator\Models\Location;
use App\IpLocator\Interfaces\Locator;

class IpGeoLocationLocator implements Locator
{
    public function __construct(
        protected HttpClient $httpClient,
        protected string $apiKey
    )
    {}
    
    /** @throws Exception */
    public function locate(Ip $ip): ?Location
    {
        $response = $this->httpClient->get(`https://api.ipgeolocation.io/ipgeo?apiKey={$this->apiKey}&ip={$ip->ip}`);
        
        return new Location(
            city: $response['city'],
            region: $response['region'],
            country: $response['country_name']
        );
    }
}