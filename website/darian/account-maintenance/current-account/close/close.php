<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account */
// start a session
session_start();
// TODO could this entire thing just self submit into index.php?
include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
// include $_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php';
date_default_timezone_set("UTC");

// gets the accountNo
$accountNo = $_SESSION["accountno"];

// creates the new current account
$sql1 = "INSERT INTO `Current Account` (accountNumber, balance, overdraftLimit)
VALUES ($accountNo,$_POST[initbal],$_POST[overdraftlimit])";

// checks that the sql query was successful
if (!mysqli_query($con, $sql1)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query1: " . mysqli_error($con));
}

$sql2 = "SELECT accountId FROM `Current Account` WHERE accountNumber = $accountNo";

$result = mysqli_query($con, $sql2);
// checks that the sql query was successful
if (!$result) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query2: " . mysqli_error($con));
}
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    // stores the retrieved account id
    $accountId = $row["accountId"];

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
    // makes the initial transaction
    $sql4 = "INSERT INTO `Current Account History` (accountId, date, transactionType, amount, balance)
VALUES ('$accountId','$now','Lodgement','$_POST[initbal]','$_POST[initbal]');";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql4)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query4: " . mysqli_error($con));
    }

    // sets the message to show to the user
    $_SESSION["message"] = "Current account closed with account number: " . $accountNo;
    // sends the user back to the form
    header("Location: ./");
}

// closes the connection
mysqli_close($con);
