<?php
include "../db.inc.php";
date_default_timezone_set("UTC");

if (!$con) {
    die("Error connecting to the database" . mysqli_connect_error());
}

$sql = "SELECT `Customer`.`customerNo`, `Customer`.`firstName`, `Customer`.`surName`, `Customer`.`address`, `Customer`.`eircode`, `Customer`.`dateOfBirth`, `Customer`.`telephoneNo`, `Customer`.`occupation`, `Customer`.`salary`, `Customer`.`emailAddress`, `Customer`.`guarantorName`, `Current Account`.`accountId`, `Current Account`.`accountNumber`, `Current Account`.`balance` FROM `Customer/CurrentAccount` INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo`=`Customer`.`customerNo` INNER JOIN `Current Account` ON `Customer/CurrentAccount`.`accountId`=`Current Account`.`accountId`";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error querying the database" . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
}
