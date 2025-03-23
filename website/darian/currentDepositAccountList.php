<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 19/03/2025
Current/Deposit Account List */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// stores the SQL statement to be queried later
// selects the accounts and joins the customer to ensure an account from a deleted customer isn't selected
// can display all accounts if no customer number is entered, or only the accounts of a customer if it is entered
$sql = "SELECT accountNumber FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Current Account`.deletedFlag = 0" . (!empty($_POST["cid"]) ? " AND Customer.customerNo = $_POST[cid]" : "") . "
UNION (SELECT accountNumber FROM `Deposit Account`
INNER JOIN `Customer/Deposit Account` ON `Deposit Account`.accountId = `Customer/Deposit Account`.accountId
INNER JOIN `Customer` ON `Customer/Deposit Account`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Deposit Account`.deletedFlag = 0" . (!empty($_POST["cid"]) ? " AND Customer.customerNo = $_POST[cid]" : "") . ")";

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// goes through all the accounts in the result
while ($row = mysqli_fetch_array($result)) {
    // echos out each account to the form
    echo "<option value='$row[accountNumber]' />";
}

// closes the connection
mysqli_close($con);
