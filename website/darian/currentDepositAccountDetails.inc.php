<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 16/03/2025
Current/Deposit Account details */
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
global $validAccount;

$validAccount = false;

$sql = "SELECT balance, overdraftLimit, 'Current' AS 'type', `Customer`.customerNo FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Current Account`.deletedFlag = 0" . (!empty($_POST["accountno"]) ? " AND accountNumber = $_POST[accountno]" : "") . "
UNION (SELECT balance, '0' AS 'overdraftLimit', 'Deposit' AS 'type', `Customer`.customerNo FROM `Deposit Account`
INNER JOIN `Customer/Deposit Account` ON `Deposit Account`.accountId = `Customer/Deposit Account`.accountId
INNER JOIN `Customer` ON `Customer/Deposit Account`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Deposit Account`.deletedFlag = 0" . (!empty($_POST["accountno"]) ? " AND accountNumber = $_POST[accountno]" : "") . ")";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 1) {
    $validAccount = true;

    $row = mysqli_fetch_array($result);
    $_SESSION["balance"] = $row["balance"];
    $_SESSION["overdraftLimit"] = $row["overdraftLimit"];
    $_SESSION["type"] = $row["type"];
    if (empty($_POST["cid"])) $_POST["cid"] = $row["customerNo"];
} else {
    unset($_SESSION["balance"]);
    unset($_SESSION["overdraftLimit"]);
    unset($_SESSION["type"]);
    $_SESSION["errorMsg"] .= "No record found for account number: $_POST[accountno]<br>Please try again!<br>";
}

mysqli_close($con);
