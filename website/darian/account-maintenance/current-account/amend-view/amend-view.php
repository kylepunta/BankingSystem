<?php
require_once '../../../../config.php';

/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account */

// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_POST["accountno"];
$overdraftLimit = floatval($_POST["overdraftlimit"]);

// checks that the overdraft limit is positive
if ($overdraftLimit < 0) {
    // error
    $_SESSION["errorMsg"] .= "Overdraft limit cannot be below 0.<br>Set to 0 for no overdraft.<br>";
}

// stores the SQL statement to be queried later
// gets the balance on the account
$sql = "SELECT balance FROM `Current Account` WHERE accountNumber = '$accountNo'";

// checks that the sql query was successful
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
    $balance = floatval(mysqli_fetch_array($result)["balance"]);

    // calculate the minimum overdraft limit allowed for the accounts current balance
    $minOverdraftLimit = 0 - $balance;
    // the limit is 0 if the customer had a positive balance (0 - -x  =  +x)
    if ($minOverdraftLimit < 0) $minOverdraftLimit = 0;

    // checks that the overdraft limit is less than the minimum
    if ($overdraftLimit < $minOverdraftLimit) {
        // error
        $_SESSION["errorMsg"] .= "The overdraft limit of $overdraftLimit doesn't allow for the current balance of €$balance.<br>
Please increase the overdraft limit to at least €$minOverdraftLimit<br>";
    }
}

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
