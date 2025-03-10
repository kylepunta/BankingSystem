<!--
Name: Oliwier Jakubiec
Date: 13/2/2025
ID : C00296807
Title: database include php
	-->
<?php 
    $hostname = "localhost";    // hostname
    $username = "bankDB";       // username for db user
    $password = "BankSecure1*"; // password for db user

    $dbname = "bankDB";         // name of database

    // create the connection
    $con = mysqli_connect($hostname, $username, $password, $dbname);

    // check the connection
    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>