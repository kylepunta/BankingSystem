<?php
require_once '../../config.php';
// Name: Brandon Jaroszczak //
// Student ID: C00296052 //
// Month: February 2025 //
// Purpose: Dropdown box generated from contents of database table //
require '../../db.inc.php'; // database connection
date_default_timezone_set('UTC');

// select all customers that are not deleted
$sql = "SELECT * FROM Customer WHERE DeletedFlag=0";

if (!$result = mysqli_query($con, $sql)) {
    die('Error in querying the database ' . mysqli_error($con));
}

// if the value of selected customer is not null then store it in the variable, otherwise store empty string
// ?? means if $_SESSION is null or doesn't exist then result will be ''
$selectedCustomer = $_SESSION['number'] ?? ''; // Retrieve stored number or empty string
echo "<select name='listbox' id='listbox' onclick='populate()'>";

// load in values from database and into the select dropdown
while ($row = mysqli_fetch_array($result)) {
    $customerNo = $row['customerNo'];
    $fullName = $row['firstName'] . " " . $row['surName'];
    $address = $row['address'];
    $eircode = $row['eircode'];
    $dob = date_create($row['dateOfBirth']);
    $dob = date_format($dob, "Y-m-d");
    $allText = "$customerNo ¬$fullName ¬$address ¬$eircode ¬$dob"; // ¬ has to be used as addresses may contain a , inside them breaking the string

    // Check if the current customer should be selected
    // If both statements are true then use the value beside the ? otherwise use the value beside : (ternary operator)
    $selected = ($customerNo == $selectedCustomer) ? "selected" : "";

    echo "<option value='$allText' $selected>$fullName</option>";
}
echo "</select>";
// close connection
mysqli_close($con);
