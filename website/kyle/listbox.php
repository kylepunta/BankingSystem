<!--
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A PHP file that renders a list of option elements that contain values from the Customer table
-->

<?php
include "../db.inc.php"; // connects to the database
date_default_timezone_set("UTC"); // sets the default timezone to UTC

if (!$con) { // throws an error if an error occurs connecting to the database
    die("Database connection failed" . mysqli_connect_error());
}

$sql = "SELECT * FROM Customer WHERE deletedFlag=0"; // select all customers from the Customer table that have not been deleted
$result = mysqli_query($con, $sql); // execute SQL query

if (!$result) { // throws an error if SQL query fails
    die("Error fetching query from the database" . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) { // while a row from the SQL query result set is returned and exists
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

mysqli_close($con); // closes the database connection
