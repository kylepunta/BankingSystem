<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 18/03/2025
Current Account Transactions */
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
// code that displays a balance as debit/credit
include $_SERVER["DOCUMENT_ROOT"] . '/darian/balance.inc.php'; // I include this rather than require it because it's already been required elsewhere, which causes a Fatal error: Cannot redeclare displayBalance()

// gets the transactions from a current account, orders them in descending order
$sql = "SELECT date, transactionType, amount, `Current Account History`.balance
FROM `Current Account History`
INNER JOIN `Current Account` ON `Current Account History`.accountId = `Current Account`.accountId
WHERE deletedFlag = 0 AND accountNumber =" . (!empty($_POST["accountno"]) ? "$_POST[accountno]" : "0") . "
ORDER BY `Current Account History`.accountId, date DESC, transactionId DESC";

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// table header
echo "<tr><th>Date</th><th>Type</th><th>Amount</th><th>Balance</th></tr>";

// keeps track of how many transactions are being displayed
$i = 0;
// loops until 10 transactions are displayed or there's no more transactions
while ($i < 10 && $row = mysqli_fetch_array($result)) {
    // gets the values from the row
    $date = $row["date"];
    $type = $row["transactionType"];
    $amount = $row["amount"];
    $balance = $row["balance"];
    // echos out the row with the date, type, amount, and formatted balance
    echo "<tr><td>$date</td><td>$type</td><td>€$amount</td><td>" . displayBalance($balance) . "</td></tr>";
    $i++;
}

// closes the connection
mysqli_close($con);