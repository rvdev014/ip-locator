<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\IpLocator\MuteLocator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\Services\HttpClient;
use App\IpLocator\IpGeoLocationLocator;
use App\IpLocator\Handlers\ErrorHandler;
use App\IpLocator\IpInfoLocationLocator;

class LocatorTest extends TestCase
{
    public function test_locate_ip_geo(): void
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->method('get')->willReturn('{
            "country_name": "United States",
            "city": "Mountain View",
            "state_prov": "California"
        }');
        
        $locator = new IpGeoLocationLocator($httpClient, 'qweqwe');
        $result = $locator->locate(new Ip('8.8.8.8'));
        
        $this->assertNotNull($result);
        $this->assertEquals('United States', $result->country);
        $this->assertEquals('Mountain View', $result->city);
        $this->assertEquals('California', $result->region);
    }
    
    public function test_locate_ip_info(): void
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->method('get')->willReturn('{
            "country": "United States",
            "city": "Mountain View",
            "region": "California"
        }');
        
        $locator = new IpInfoLocationLocator($httpClient, 'qweqwe');
        $result = $locator->locate(new Ip('8.8.8.8'));
        
        $this->assertNotNull($result);
        $this->assertEquals('United States', $result->country);
        $this->assertEquals('Mountain View', $result->city);
        $this->assertEquals('California', $result->region);
    }
    
    public function test_locate_not_found(): void
    {
        $locator = new MuteLocator(
            new IpGeoLocationLocator(new HttpClient(), '4a7e33e4adf34da1a1d8f6e4f4c954e1'),
            new ErrorHandler()
        );
        $result = $locator->locate(new Ip('127.0.0.1'));
        $this->assertNull($result);
    }
}