<?php

namespace App\IpLocator\Services;

interface Cache
{
    public function get(string $key): ?string;

    public function set(string $key, $value, int $ttl): void;
}