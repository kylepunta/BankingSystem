<?php
// TODO could this entire thing just self submit into index.php?
include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
date_default_timezone_set("UTC");

// loops until badNo is false (a safe account number was generated)
$badNo = true;
while ($badNo) {
    // generate a random 8 digit account number
    $acccountNo = rand(10000000, 99999999);

    // queries each account type for an account matching the given account number
    // TODO use count() and condense into one query
    // TODO do account numbers need to be unique of deleted accounts too? (deleted flag)
    $sql1 = "SELECT accountNumber FROM `Current Account` WHERE accountNumber = $acccountNo";
    $sql2 = "SELECT accountNumber FROM `Deposit Account` WHERE accountNumber = $acccountNo";
    $sql3 = "SELECT accountNumber FROM `Loan Account` WHERE accountNumber = $acccountNo";

    // run the query for each account type
    $result1 = mysqli_query($con, $sql1);
    $result2 = mysqli_query($con, $sql2);
    $result3 = mysqli_query($con, $sql3);

    // counts the number of accounts with the given account number
    $numOfAccounts1 = mysqli_num_rows($result1);
    $numOfAccounts2 = mysqli_num_rows($result2);
    $numOfAccounts3 = mysqli_num_rows($result3);

    // checks if the account number exists on any other account type
    if ($numOfAccounts1 == 0 && $numOfAccounts2 == 0 && $numOfAccounts3 == 0) {
        // this account number is safe
        $badNo = false;
    }
}

// creates the new current account
$sql1 = "INSERT INTO `Current Account` (accountNumber, overdraftLimit)
VALUES ($acccountNo,$_POST[overdraftlimit])";

// links the current account to the customer
$sql2 = "INSERT INTO `Customer/CurrentAccount` (customerNo, accountId)
VALUES ($_POST[cid],$acccountNo)";

// checks that the sql query was successful
if (!mysqli_query($con, $sql1) || !mysqli_query($con, $sql2)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

mysqli_close($con);
