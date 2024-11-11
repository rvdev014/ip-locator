<?php

namespace Tests\Unit;

use Tests\TestCase;
use InvalidArgumentException;
use App\IpLocator\Models\Entities\Ip;

class IpTest extends TestCase
{
    public function test_success_ip(): void
    {
        $ip = new Ip($expected = '8.8.8.8');
        $this->assertEquals($ip->value, $expected);
    }
    
    public function test_empty_ip(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('IP address cannot be empty');
        
        new Ip('');
    }
    
    public function test_invalid_ip(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid IP address');
        
        new Ip('invalid');
    }
}