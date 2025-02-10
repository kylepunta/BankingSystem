<?php 
    $hostname = "localhost";
    $username = "bankDB";
    $password = "BankSecure1*";

    $dbname = "bankDB";

    $con = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>