<?php

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
    <form action="geolocate.php" method="post">
        <label for="ip">Enter IP Address:</label>
        <input type="text" name="ip" id="ip">
        <button type="submit">Geolocate</button>
    </form>
</body>
</html>
