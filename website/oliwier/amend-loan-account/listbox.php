<?php
include 'db.inc.php';
date_default_timezone_set("UTC");

$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo FROM Customer WHERE deletedFlag = 0";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

$selectedCust = $_SESSION['customerID'] ?? '';

echo "<option value='placeholder'>Select a customer</option>";
while ($row = mysqli_fetch_array($result)) {
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $name = $fname . " " . $lname;
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $phone = $row["telephoneNo"];
    $allText = "$id#$addr#$eircode#$dob#$phone";

    $selected = ($id == $selectedCust) ? "selected" : "";
    echo "<option value='$allText' $selected>$name</option>";
}

mysqli_close($con);
