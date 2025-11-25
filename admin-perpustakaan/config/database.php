<?php

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'perpustakaan';

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    die('Koneksi database gagal: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');

/**
 * Get global mysqli connection.
 */
function db(): mysqli
{
    global $mysqli;
    return $mysqli;
}


