<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account */

global $con;
global $validId;

include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
date_default_timezone_set("UTC");

$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer WHERE deletedFlag = 0";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

$validId = false;

while ($row = mysqli_fetch_array($result)) {
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $name = $fname . " " . $lname;
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $allText = "$id §$addr §$eircode §$dob"; // details split by § as it shouldn't appear in a persons address (unlike commas)

    if (isset($_POST["cid"]) && $_POST["cid"] == $id) {
        $validId = true;
        echo "<option value='$allText' selected>$name</option>";
    } else {
        echo "<option value='$allText'>$name</option>";
    }
}

mysqli_close($con);
