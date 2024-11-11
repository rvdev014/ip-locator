<?php

require __DIR__ . '/vendor/autoload.php';

use App\IpLocator\CacheLocator;
use App\IpLocator\ChainLocator;
use App\IpLocator\Handlers\ErrorHandler;
use App\IpLocator\IpGeoLocationLocator;
use App\IpLocator\IpInfoLocationLocator;
use App\IpLocator\Models\Entities\Ip;
use App\IpLocator\MuteLocator;
use App\IpLocator\Services\FileCache;
use App\IpLocator\Services\HttpClient;

$ip = $_POST['ip'] ?? null;

$handler = new ErrorHandler();
$client = new HttpClient();
$cache = new FileCache();

$ipLocator = new ChainLocator(
    new CacheLocator(
        new MuteLocator(
            new IpGeoLocationLocator($client, '4a7e33e4adf34da1a1d8f6e4f4c954e1'),
            $handler
        ),
        $cache,
        'ip-geo',
        3600
    ),
    new CacheLocator(
        new MuteLocator(
            new IpInfoLocationLocator($client, 'e15f1f2e9a3b68'),
            $handler
        ),
        $cache,
        'ip-info',
        3600
    ),
)

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP Geolocator</title>
</head>
<body>
<h1>IP Geolocator</h1>
<form action="" method="post">
    <label for="ip">Enter IP Address:</label>
    <input type="text" name="ip" id="ip">
    <button type="submit">Geolocate</button>
</form>

<?php
if ($ip) {
    try {
        $location = $ipLocator->locate(new Ip($ip));

        if ($location === null) {
            echo "<p>Location not found for IP: $ip</p>";
        } else {
            echo "<p>Location for IP: $ip</p>";
            echo "<ul>";
            echo "<li>Country: $location->country</li>";
            echo "<li>City: $location->city</li>";
            echo "<li>Region: $location->region</li>";
            echo "</ul>";
        }

    } catch (Throwable $e) {
        echo "<p>Error: {$e->getMessage()}</p>";
    }
}
?>

</body>
</html>
