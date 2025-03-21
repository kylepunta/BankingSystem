<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
global $validId;

$validId = false;

// stores the SQL statement to be queried later
$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer
WHERE deletedFlag = 0 AND Customer.customerNo = " . (!empty($_POST["cid"]) ? "$_POST[cid]" : "0");

if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 1) {
    $validId = true;

    $row = mysqli_fetch_array($result);
    $_SESSION["address"] = $row["address"];
    $_SESSION["eircode"] = $row["eircode"];
    $_SESSION["dob"] = $row["dateOfBirth"];
} else {
    unset($_SESSION["address"]);
    unset($_SESSION["eircode"]);
    unset($_SESSION["dob"]);
    $_SESSION["errorMsg"] .= "No record found for customer number: $_POST[cid]<br>Please try again!<br>";
}

mysqli_close($con);
