<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 16/03/2025
Current Account List */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// stores the SQL statement to be queried later
$sql = "SELECT accountNumber FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN Customer ON Customer.customerNo = `Customer/CurrentAccount`.customerNo
WHERE Customer.deletedFlag = 0 AND `Current Account`.deletedFlag = 0 " . (!empty($_POST["cid"]) ? "AND Customer.customerNo = $_POST[cid]" : "");

if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    echo "<option value='$row[accountNumber]' />";
}

mysqli_close($con);
