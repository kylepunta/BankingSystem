<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account */
// start a session
session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
date_default_timezone_set("UTC");

//TODO error detect

// marks the current account for deletion
$sql1 = "UPDATE `Current Account` SET deletedFlag = 1 WHERE accountNumber = $_POST[accountno]";

// checks that the sql query was successful
if (!mysqli_query($con, $sql1)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query1: " . mysqli_error($con));
}

// sets the message to show to the user
$_SESSION["message"] = "Current account closed with account number: " . $_POST["accountno"];

// cleanup
session_unset();
unset($_POST["cid"]);

// closes the connection
mysqli_close($con);
