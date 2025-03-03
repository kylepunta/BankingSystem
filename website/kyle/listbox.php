<?php
include "../db.inc.php";
date_default_timezone_set("UTC");

if (!$con) {
    die("Database connection failed" . mysqli_connect_error());
}

$sql = "SELECT * FROM Customer";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error fetching query from the database" . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    $customerID = $row['customerNo'];
    $firstName = $row['firstName'];
    $lastName = $row['surName'];
    $address = $row['address'];
    $eircode = $row['eircode'];
    $dateOfBirth = $row['dateOfBirth'];
    $telephoneNo = $row['telephoneNo'];
    $occupation = $row['occupation'];
    $salary = $row['salary'];
    $email = $row['emailAddress'];
    $guarantorName = $row['guarantorName'];
    $values = "$customerID,$firstName,$lastName,$address,$eircode,$dateOfBirth,$telephoneNo,$occupation,$salary,$email,$guarantorName";
    echo "<option value='{$values}'>{$customerID} - {$firstName} {$lastName}</option>";
}

mysqli_close($con);
