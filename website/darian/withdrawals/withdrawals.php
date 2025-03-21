<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 10/03/2025
Withdrawals */
// start a session
session_start();
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_POST["accountno"];

// converts and stores POSTed values to floats from strings
$withdrawalamt = floatval($_POST["withdrawalamt"]);

// checks if the withdrawal amount is below 0
if ($withdrawalamt < 0) {
    // error
    $_SESSION["errorMsg"] .= "Withdrawal amount of $withdrawalamt is less than 0. It must be greater than 0!<br>";
}

// stores the SQL statement to be queried later
// gets the accountId, balance, and overdraftLimit from the current or deposit account of the customer
// checks if the account type is deposit and replaces the missing overdraftLimit column if it is
$sql = "SELECT accountId, balance," . ($_POST["accounttype"] == "Deposit" ? " '0' AS" : "") . " overdraftLimit
    FROM `$_POST[accounttype] Account` WHERE deletedFlag = 0 AND accountNumber = '$_POST[accountno]'";

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
    // gets the row from the result
    $row = mysqli_fetch_array($result);
    // stores the values in the row
    $accountId = $row["accountId"];
    $balance = floatval($row["balance"]);
    $overdraftLimit = floatval($row["overdraftLimit"]);
    // calculates the new balance
    $newbal = $balance - $withdrawalamt;

    // checks that the new balance is within the accounts limit
    if ($newbal < 0 - $overdraftLimit) {
        // sets the message to show to the user
        $_SESSION["errorMsg"] .= "The withdrawal of €$_POST[withdrawalamt] from balance €$balance exceeds the overdraft limit of €$overdraftLimit.
            <br>The new balance would have been €$newbal.";
    }
}

// checks that there are no error messages
if (empty($_SESSION["errorMsg"])) {
    // stores the SQL statement to be queried later
    // updates a row in the current or deposit account table, uses the user input to set the new balance
    $sql = "UPDATE `$_POST[accounttype] Account` SET balance='$newbal' WHERE accountId = '$accountId'";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query: " . mysqli_error($con));
    }

    // gets the current date
    $now = date("Y-m-d");
    // stores the SQL statement to be queried later
    // makes the withdrawal transaction
    // checks if the account type is deposit and uses the correct column name if it is
    $sql = "INSERT INTO `$_POST[accounttype] Account History` (accountId, date, transactionType, "
        . ($_POST["accounttype"] == "Deposit" ? "transactionAmount" : "amount") . ", balance)
        VALUES ('$accountId','$now','Withdrawal','$_POST[withdrawalamt]','$newbal');";

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
    $_SESSION["message"] = "Withdrawal of €$withdrawalamt made from $_POST[accounttype] Account with Account Number: $accountNo.";
}

// closes the connection
mysqli_close($con);
