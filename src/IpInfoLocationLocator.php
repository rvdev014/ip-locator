<?php

namespace App\IpLocator;

use Exception;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Interfaces\Locator;
use App\IpLocator\Services\HttpClient;
use App\IpLocator\Models\Entities\Location;

class IpInfoLocationLocator implements Locator
{
    public function __construct(
        protected HttpClient $httpClient,
        protected string     $apiKey
    ) {}
    
    /** @throws Exception */
    public function locate(Ip $ip): ?Location
    {
        $url = "https://ipinfo.io/$ip->value?token=$this->apiKey";
        
        $response = $this->httpClient->get($url);
        $data = json_decode($response, true);
        
        if (empty($data['country'])) {
            return null;
        }
        
        return new Location(
            country: $data['country'],
            city: $data['city'],
            region: $data['region']
        );
    }
}