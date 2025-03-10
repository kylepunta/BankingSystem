<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account */
// TODO server side validation
// start a session
session_start();
// TODO could this entire thing just self submit into index.php?
include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
date_default_timezone_set("UTC");

// stores the SQL statement to be queried later
// updates a row in the Student table, uses the user input to set the name, address, phone number, GPA, DOB, year began course, and course code
$sql = "UPDATE `Current Account` SET overdraftLimit = '$_POST[overdraftlimit]' WHERE accountNumber = '$_POST[accountno]'";

// checks that the sql query was successful
if (!mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// sets the message to show to the user
$_SESSION["message"] = "Current account with account number: $_POST[accountno] amended.";

// sends the user back to the form
header("Location: ./");

// closes the connection
mysqli_close($con);
