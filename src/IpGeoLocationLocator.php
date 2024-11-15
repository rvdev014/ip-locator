<?php

namespace App\IpLocator;

use Exception;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Interfaces\Locator;
use App\IpLocator\Services\HttpClient;
use App\IpLocator\Models\Entities\Location;

class IpGeoLocationLocator implements Locator
{
    public function __construct(
        protected HttpClient $httpClient,
        protected string     $apiKey
    ) {}
    
    /** @throws Exception */
    public function locate(Ip $ip): ?Location
    {
        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
                'apiKey' => $this->apiKey,
                'ip' => $ip->value
            ]);
        
        $response = $this->httpClient->get($url);
        $data = json_decode($response, true);
        
        if (empty($data['country_name'])) {
            return null;
        }
        
        return new Location(
            country: $data['country_name'],
            city: $data['city'],
            region: $data['state_prov']
        );
    }
}