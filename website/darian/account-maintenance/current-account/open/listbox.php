<?php
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
    $allText = "$id,$fname,$lname,$addr,$eircode,$dob";
    echo "<option value='$allText'>$name</option>";
}

mysqli_close($con);
