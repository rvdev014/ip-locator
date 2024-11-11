<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\IpLocator\Models\Entities\Location;

class LocationTest extends TestCase
{
    public function test_location_obj(): void
    {
        $location = new Location(
            $country = 'United States',
            $city = 'Mountain View',
            $region = 'California',
        );
        
        $this->assertEquals($location->city, $city);
        $this->assertEquals($location->region, $region);
        $this->assertEquals($location->country, $country);
    }
}