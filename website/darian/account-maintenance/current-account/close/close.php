<?php
session_start();

/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account */

// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_POST["accountno"];

// stores the SQL statement to be queried later
// gets the balance on the account
$sql = "SELECT `balance` FROM `Current Account` WHERE accountNumber = $accountNo";

if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}
// checks that only one account was queried
if (mysqli_num_rows($result) != 1) {
    // error
    $_SESSION["errorMsg"] .= "No record found for account number: $accountNo<br>";
} else {
    // gets the balance on the account
    $balance = mysqli_fetch_array($result)["balance"];

    // checks that the account balance is 0
    if ($balance != 0) {
        // error
        $_SESSION["errorMsg"] .= "Balance for account number: $accountNo is: $balance.<br>It must be 0 before the account can be closed.<br>";
    }
}

// checks that there are no error messages
if (empty($_SESSION["errorMsg"])) {
    // marks the current account for deletion
    $sql1 = "UPDATE `Current Account` SET deletedFlag = 1 WHERE accountNumber = $accountNo";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql1)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query1: " . mysqli_error($con));
    }

    // cleanup
    session_unset();
    unset($_POST["cid"]);
    unset($_POST["accountno"]);

    // sets the message to show to the user
    $_SESSION["message"] = "Current account closed with account number: " . $accountNo;
}

// closes the connection
mysqli_close($con);
