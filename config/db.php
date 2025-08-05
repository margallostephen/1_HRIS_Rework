<?php

$host = 'localhost';
$user = 'root';
$pass = '';

$dbMain     = '1_hris';
$dbAddress  = 'philippines_address';

$mysqli         = new mysqli($host, $user, $pass, $dbMain);
$mysqliAddress  = new mysqli($host, $user, $pass, $dbAddress);

if ($mysqli->connect_error || $mysqliAddress->connect_error) {
    exit('Database connection failed: ' . ($mysqli->connect_error ?: $mysqliAddress->connect_error));
}
