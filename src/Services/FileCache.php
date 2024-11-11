<?php

namespace App\IpLocator\Services;

class FileCache implements Cache
{

    public function get(string $key): ?string
    {
        return null;
    }

    public function set(string $key, $value, int $ttl): void
    {
        // TODO: Implement set() method.
    }
}