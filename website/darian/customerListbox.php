<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Customer List box */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
// set the default timezone
date_default_timezone_set("UTC");

// stores the SQL statement to be queried later
// selects all customers who aren't deleted
$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth FROM Customer WHERE deletedFlag = 0";

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// goes through all the customers in the result
while ($row = mysqli_fetch_array($result)) {
    // gets the values from the row
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $name = $fname . " " . $lname;
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    // joins all the details into one string
    $allText = "$id §$addr §$eircode §$dob"; // details split by § as it shouldn't appear in a persons address (unlike commas)

    // if a customer number was POSTed and matches the one in the current rom
    if (isset($_POST["cid"]) && $_POST["cid"] == $id) {
        // mark this option as the selected one
        echo "<option value='$allText' selected>$name</option>";
    } else {
        // otherwise just echo out the option
        echo "<option value='$allText'>$name</option>";
    }
}

// closes the connection
mysqli_close($con);
