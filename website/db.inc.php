<!-- Name: Group work -->
<!-- Purpose: DB inc file to connect to database used by all php pages -->
<?php
$hostname = "localhost";
$username = "bankDB";
$password = "BankSecure1*";

$dbname = "bankDB";

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
