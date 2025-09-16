<?php
$hostname = "localhost";
$username = "bankapp";
$password = "#New_Strong_Password_123";

$dbname = "bank_system";

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
