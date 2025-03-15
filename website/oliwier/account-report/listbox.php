<?php
include 'db.inc.php';
date_default_timezone_set("UTC");

$sql = "SELECT customerNo, firstName, surName, address, dateOfBirth, telephoneNo  
        FROM `Customer` WHERE deletedFlag = 0;";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

$selectedCust = $_SESSION['customerID'] ?? '';
// $selectedCust = '';

echo "<option value='placeholder'>Select a customer</option>";

while ($row = mysqli_fetch_array($result)) {
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $addr = $row["address"];
    $dob = $row["dateOfBirth"];
    $phone = $row["telephoneNo"];
    $name = $fname . " " . $lname;
    $allText = "$id#$addr#$dob#$phone";

    $selected = ($id == $selectedCust) ? "selected" : "";
    echo "<option value='$allText' $selected>$name</option>";
}

mysqli_close($con);
