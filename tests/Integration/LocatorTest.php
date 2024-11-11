<?php

namespace Tests\Integration;

use App\IpLocator\Handlers\ErrorHandler;
use App\IpLocator\IpGeoLocationLocator;
use App\IpLocator\IpInfoLocationLocator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\MuteLocator;
use App\IpLocator\Services\HttpClient;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class LocatorTest extends TestCase
{
    public function test_locate_ip_geo(): void
    {
        $locator = new IpGeoLocationLocator($this->mockClient(), 'qweqwe');
        $result = $locator->locate(new Ip('8.8.8.8'));

        $this->assertNotNull($result);
        $this->assertEquals('United States', $result->country);
        $this->assertEquals('Mountain View', $result->city);
        $this->assertEquals('California', $result->region);
    }

    public function test_locate_ip_info(): void
    {
        $locator = new IpInfoLocationLocator($this->mockClient(), 'qweqwe');
        $result = $locator->locate(new Ip('8.8.8.8'));

        $this->assertNotNull($result);
        $this->assertEquals('United States', $result->country);
        $this->assertEquals('Mountain View', $result->city);
        $this->assertEquals('California', $result->region);
    }

    public function test_locate_not_found(): void
    {
        $locator = new MuteLocator(
            new IpGeoLocationLocator($this->mockClient(true), '4a7e33e4adf34da1a1d8f6e4f4c954e1'),
            new ErrorHandler()
        );
        $result = $locator->locate(new Ip('127.0.0.1'));
        $this->assertNull($result);
    }

    protected function mockClient(bool $withException = false): HttpClient|MockObject
    {
        $httpClient = $this->createMock(HttpClient::class);

        $method = $httpClient
            ->method('get')
            ->willReturn(
                '{
                "country": "United States",
                "country_name": "United States",
                "city": "Mountain View",
                "state_prov": "California",
                "region": "California"
            }'
            );

        if ($withException) {
            $method->willThrowException(new Exception());
        }

        return $httpClient;
    }
}