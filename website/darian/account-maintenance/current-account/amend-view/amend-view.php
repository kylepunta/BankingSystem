<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account */
// TODO server side validation
// start a session
session_start();
include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
global $con;
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_POST["accountno"];

// TODO error detection
// cant have overdraft limit below 0
// 0 - overdraft limit cant be greater than the current balance

// checks that there are no error messages
if (empty($_SESSION["errorMsg"])) {
    // stores the SQL statement to be queried later
    // updates a row in the current account table, uses the user input to set the overdraft limit
    $sql = "UPDATE `Current Account` SET overdraftLimit = '$_POST[overdraftlimit]' WHERE accountNumber = '$accountNo'";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query: " . mysqli_error($con));
    }

    // cleanup
    session_unset();
    unset($_POST["cid"]);
    unset($_POST["accountno"]);

    // sets the message to show to the user
    $_SESSION["message"] = "Current account with account number: $accountNo amended.";
}

// closes the connection
mysqli_close($con);
