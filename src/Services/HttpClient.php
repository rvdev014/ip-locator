<?php

namespace App\IpLocator\Services;

use Exception;
use RuntimeException;

class HttpClient
{
    /** @throws Exception */
    public function get($url): string
    {
        $response = @file_get_contents($url);
        if ($response === false) {
            throw new RuntimeException(error_get_last()['message'] ?? 'Unknown error');
        }
        
        return $response;
    }
}