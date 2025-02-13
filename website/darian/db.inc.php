<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Project */
// variables used to access the database
$hostname = "localhost";
$username = "bankDB";
$password = "BankSecure1*";

// the database to access
$dbname = "bankDB";

// creates and stores a connection to the database
$con = mysqli_connect($hostname, $username, $password, $dbname);

// checks that the connection to the database was successful
if (!$con) {
    // displays the error that caused the connection to fail
    // exits the script
    die("Failed to connect to MySQL: " + mysqli_connect_error());
}
