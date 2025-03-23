<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 16/03/2025
Current/Deposit Account details */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
global $validAccount;

// default to false
$validAccount = false;

// stores the SQL statement to be queried later
// selects the account details and joins the customer to ensure an account from a deleted customer isn't selected
// if no account is POSTed, all accounts are selected then later a check for only 1 account is made
$sql = "SELECT balance, overdraftLimit, 'Current' AS 'type', `Customer`.customerNo FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Current Account`.deletedFlag = 0" . (!empty($_POST["accountno"]) ? " AND accountNumber = $_POST[accountno]" : "") . "
UNION (SELECT balance, '0' AS 'overdraftLimit', 'Deposit' AS 'type', `Customer`.customerNo FROM `Deposit Account`
INNER JOIN `Customer/Deposit Account` ON `Deposit Account`.accountId = `Customer/Deposit Account`.accountId
INNER JOIN `Customer` ON `Customer/Deposit Account`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Deposit Account`.deletedFlag = 0" . (!empty($_POST["accountno"]) ? " AND accountNumber = $_POST[accountno]" : "") . ")";

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// checks that only one account was queried
if (mysqli_num_rows($result) == 1) {
    // sets the valid account to true so that other pieces of code can run elsewhere
    $validAccount = true;

    // gets the row from the result
    $row = mysqli_fetch_array($result);
    // stores the values in the row
    $_SESSION["balance"] = $row["balance"];
    $_SESSION["overdraftLimit"] = $row["overdraftLimit"];
    $_SESSION["type"] = $row["type"];
    // sets the customer number on the form if one wasn't entered by the user
    if (empty($_POST["cid"])) $_POST["cid"] = $row["customerNo"];
} else {
    // clears the values before they are displayed on the form
    unset($_SESSION["balance"]);
    unset($_SESSION["overdraftLimit"]);
    unset($_SESSION["type"]);
    // sends an error message to display to the user
    $_SESSION["errorMsg"] .= "No record found for account number: $_POST[accountno]<br>Please try again!<br>";
}

// closes the connection
mysqli_close($con);
