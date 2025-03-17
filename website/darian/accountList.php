<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 16/03/2025
Account List */
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
date_default_timezone_set("UTC");

$sql = "SELECT accountNumber FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN Customer ON Customer.customerNo = `Customer/CurrentAccount`.customerNo
WHERE Customer.deletedFlag = false AND `Current Account`.deletedFlag = false " . (!empty($_POST["cid"]) ? "AND Customer.customerNo = $_POST[cid]" : "");

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    echo "<option value='$row[accountNumber]' />";
}

mysqli_close($con);
