<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details */
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php');
global $con;

$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer WHERE customerNo = $_POST[cid] AND deletedFlag = 0";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 1) {
    if (!isset($_SESSION["accountno"])) $_SESSION["accountno"] = generateAccountNo();

    $row = mysqli_fetch_array($result);
    $_SESSION["address"] = $row["address"];
    $_SESSION["eircode"] = $row["eircode"];
    $_SESSION["dob"] = $row["dateOfBirth"];
} else {
    $errorMsg = $_SESSION["errorMsg"];
    session_unset();
    $_SESSION["errorMsg"] = $errorMsg . "No record found for customer number: $_POST[cid]<br>Please try again!<br>";
}

mysqli_close($con);
