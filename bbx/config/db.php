<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

date_default_timezone_set('Asia/Kolkata');

error_reporting(E_ALL);


$servername = "localhost";
$username = "forge";
$password = "teh6z0NEa3g1jRlXt2Xv";
define('APP_URL','https://barberxpress.in/bbx/');

try {
    $conn = new PDO("mysql:host=$servername;dbname=barberxpress", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?> 
