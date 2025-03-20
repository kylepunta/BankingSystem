<!--
Author  : Oliwier Jakubiec
Date    : Mar 2025
ID      : C00296807
Purpose : dropdown list of customers  
-->

<?php
// include db connection and set timezone
include '../../db.inc.php';
date_default_timezone_set("UTC");

// create sql query
$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo FROM Customer WHERE deletedFlag = 0";

// check if query is successful
if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

// if customerId is not null, get the value, otherwise set it to empty string
// do the same for account number
$selectedCust = $_SESSION['customerID'] ?? '';

// create dropdown
echo "<option value='placeholder'>Select a customer</option>";

// loop through the result and create an option for each customer
while ($row = mysqli_fetch_array($result)) {
    // get the values from the row
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $name = $fname . " " . $lname;
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $phone = $row["telephoneNo"];
    $allText = "$id#$addr#$eircode#$dob#$phone";

    // if the selected customer from the session is the same as the current 
    //    customer, set the selected attribute to selected, else set it to empty string
    $selected = ($id == $selectedCust) ? "selected" : "";
    echo "<option value='$allText' $selected>$name</option>";
}
// close connection
mysqli_close($con);
