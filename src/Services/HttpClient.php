<?php

namespace App\IpLocator\Models;

use Exception;

class HttpClient
{
    /** @throws Exception */
    public function get($url): array
    {
        $response = @file_get_contents($url);
        if ($response === false) {
            throw new Exception("Could not connect to $url");
        }
        
        return json_decode($response, true);
    }
}