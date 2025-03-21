<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account */
// start a session
session_start();
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_SESSION["accountno"];

// converts and stores POSTed values to floats from strings
$overdraftlimit = floatval($_POST["overdraftlimit"]);
$initbal = floatval($_POST["initbal"]);

// checks if the overdraft limit is below 0
if ($overdraftlimit < 0) {
    // error
    $_SESSION["errorMsg"] .= "Overdraft limit of $_POST[overdraftlimit] is less than 0. It must be greater than 0!<br>";
}

// checks if the initial deposit is below 0
if ($initbal < 0) {
    // error
    $_SESSION["errorMsg"] .= "Initial deposit of $_POST[initbal] is less than 0. It must be greater than 0!<br>";
}

// stores the SQL statement to be queried later
// check that valid customer id was POSTed
$sql = "SELECT customerNo FROM Customer WHERE customerNo = $_POST[cid] AND deletedFlag = 0";
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}
// checks that only one account was queried
if (mysqli_num_rows($result) != 1) {
    // error
    $_SESSION["errorMsg"] .= "No record found for customer number: $_POST[cid]<br>";
}

// checks that there are no error messages
if (empty($_SESSION["errorMsg"])) {
    // stores the SQL statement to be queried later
    // creates the new current account
    $sql1 = "INSERT INTO `Current Account` (accountNumber, balance, overdraftLimit)
    VALUES ($accountNo,$_POST[initbal],$_POST[overdraftlimit])";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql1)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query1: " . mysqli_error($con));
    }

    // stores the SQL statement to be queried later
    $sql2 = "SELECT accountId FROM `Current Account` WHERE accountNumber = $accountNo";

    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql2)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query2: " . mysqli_error($con));
    }
    // checks that only one account was queried
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        // stores the retrieved account id
        $accountId = $row["accountId"];

        // stores the SQL statement to be queried later
        // links the current account to the customer
        $sql3 = "INSERT INTO `Customer/CurrentAccount` (customerNo, accountId)
        VALUES ($_POST[cid],$accountId)";

        // checks that the sql query was successful
        if (!mysqli_query($con, $sql3)) {
            // displays the error that caused the query to fail
            // exits the script
            die("An error in the SQL Query3: " . mysqli_error($con));
        }

        // gets the current date
        $now = date("Y-m-d");
        // stores the SQL statement to be queried later
        // makes the initial transaction
        $sql4 = "INSERT INTO `Current Account History` (accountId, date, transactionType, amount, balance)
        VALUES ('$accountId','$now','Lodgement','$_POST[initbal]','$_POST[initbal]');";

        // checks that the sql query was successful
        if (!mysqli_query($con, $sql4)) {
            // displays the error that caused the query to fail
            // exits the script
            die("An error in the SQL Query4: " . mysqli_error($con));
        }

        // cleanup
        session_unset();
        unset($_POST["cid"]);

        // sets the message to show to the user
        $_SESSION["message"] = "Current account opened with account number: " . $accountNo;
    }
}

// closes the connection
mysqli_close($con);
