<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 18/03/2025
Current Account Transactions */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// code that displays a balance as debit/credit
require_once($_SERVER["DOCUMENT_ROOT"] . '/darian/balance.inc.php'); // I use require_once because it's already been required elsewhere, which causes a Fatal error: Cannot redeclare displayBalance()

// stores the SQL statement to be queried later
// gets the transactions from a current account, joins the customer to ensure an account from a deleted customer isn't selected, and orders them in descending order
// if no account number is POSTed, the account number 0 is selected which doesn't belong to any account therefore no account is selected
$sql = "SELECT date, transactionType, amount, `Current Account History`.balance
FROM `Current Account History`
INNER JOIN `Current Account` ON `Current Account History`.accountId = `Current Account`.accountId
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo` = `Customer`.`customerNo`
WHERE `Current Account`.deletedFlag = 0 AND `Customer`.deletedFlag = 0 AND accountNumber =" . (!empty($_POST["accountno"]) ? "$_POST[accountno]" : "0") . "
ORDER BY date DESC, transactionId DESC
LIMIT 10";

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// table header
echo "<tr><th>Date</th><th>Type</th><th>Amount</th><th>Balance</th></tr>";

// loops until 10 transactions are displayed or there's no more transactions
while ($row = mysqli_fetch_array($result)) {
    // gets the values from the row
    $date = $row["date"];
    $type = $row["transactionType"];
    $amount = $row["amount"];
    $balance = $row["balance"];
    // echos out the row with the date, type, amount, and formatted balance
    echo "<tr><td>$date</td><td>$type</td><td>€$amount</td><td>" . displayBalance($balance) . "</td></tr>";
}

// closes the connection
mysqli_close($con);