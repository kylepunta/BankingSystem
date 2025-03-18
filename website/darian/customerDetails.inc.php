<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details */
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
global $con;
global $validId;

$validId = false;

$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer
WHERE deletedFlag = 0 AND Customer.customerNo = " . (!empty($_POST["cid"]) ? "$_POST[cid]" : "0");

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
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
