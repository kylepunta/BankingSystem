<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account */

// TODO could this entire thing just self submit into index.php?
include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
include $_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php';
date_default_timezone_set("UTC");

// generates the accountNo
$accountNo = generateAccountNo($con);

// creates the new current account
$sql1 = "INSERT INTO `Current Account` (accountNumber, overdraftLimit)
VALUES ($accountNo,$_POST[overdraftlimit])";

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

    // links the current account to the customer
    $sql3 = "INSERT INTO `Customer/CurrentAccount` (customerNo, accountId)
    VALUES ($_POST[cid],$row[accountId])";

    // checks that the sql query was successful
    if (!mysqli_query($con, $sql3)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query3: " . mysqli_error($con));
    }
}

// closes the connection
mysqli_close($con);
