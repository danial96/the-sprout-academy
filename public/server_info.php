<?php
echo "Server IP: " . $_SERVER['SERVER_ADDR'] . "\n";
echo "Host: " . gethostname() . "\n";
$ip = file_get_contents('https://api.ipify.org');
echo "Outbound IP: " . $ip . "\n";
