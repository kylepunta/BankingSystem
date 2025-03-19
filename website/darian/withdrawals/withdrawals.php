<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 10/03/2025
Withdrawals */
// start a session
session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_POST["accountno"];

// TODO server side validation, like in other screens

// checks that there are no error messages
if (empty($_SESSION["errorMsg"])) {
    // stores the SQL statement to be queried later
    // gets the accountId, balance, and overdraftLimit from the current or deposit account of the customer
    $sql = "SELECT accountId, balance, overdraftLimit FROM `$_POST[accounttype] Account` WHERE deletedFlag = 0 AND accountNumber = '$_POST[accountno]'";

    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query: " . mysqli_error($con));
    }

    // gets the row from the result
    $row = mysqli_fetch_array($result);
    // stores the values in the row
    $accountId = $row["accountId"];
    $balance = $row["balance"];
    $overdraftLimit = $row["overdraftLimit"];
    // calculates the new balance
    $newbal = $balance - $_POST["withdrawalamt"];

    // checks that the new balance is within the accounts limit
    if ($newbal >= 0 - $overdraftLimit) {
        // stores the SQL statement to be queried later
        // updates a row in the current or deposit account table, uses the user input to set the new balance
        $sql = "UPDATE `$_POST[accounttype] Account` SET balance='$newbal' WHERE accountId = '$accountId'";

        // checks that the sql query was successful
        if (!mysqli_query($con, $sql)) {
            // displays the error that caused the query to fail
            // exits the script
            die("An error in the SQL Query: " . mysqli_error($con));
        } else {
            // gets the current date
            $now = date("Y-m-d");
            // stores the SQL statement to be queried later
            // makes the withdrawal transaction
            $sql = "INSERT INTO `$_POST[accounttype] Account History` (accountId, date, transactionType, amount, balance)
        VALUES ('$accountId','$now','Withdrawal','$_POST[withdrawalamt]','$newbal');";

            // checks that the sql query was successful
            if (!mysqli_query($con, $sql)) {
                // displays the error that caused the query to fail
                // exits the script
                die("An error in the SQL Query: " . mysqli_error($con));
            } else {
                // sets the message to show to the user
                $_SESSION["message"] = "Withdrawal of €$_POST[withdrawalamt] made from $_POST[accounttype] Account with Account Number: $_POST[accountno].";
            }
        }
    } else {
        // sets the message to show to the user
        $_SESSION["message"] = "Error. The withdrawal of €$_POST[withdrawalamt] from balance €$balance exceeds the overdraft limit of €$overdraftLimit. The new balance would have been €$newbal.";
    }
}

// closes the connection
mysqli_close($con);
