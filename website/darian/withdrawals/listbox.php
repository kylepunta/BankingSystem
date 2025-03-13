<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 10/03/2025
Withdrawals */

include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
date_default_timezone_set("UTC");

$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer WHERE deletedFlag = 0";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $name = $fname . " " . $lname;
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $allText = "$id §$addr §$eircode §$dob"; // details split by § as it shouldn't appear in a persons address (unlike commas)
    echo "<option value='$allText'>$name</option>";
}

mysqli_close($con);
