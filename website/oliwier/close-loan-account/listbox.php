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
$sql = "SELECT Customer.customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo, 
        `Loan Account`.`accountNumber`, `Loan Account`.accountID, `Loan Account`.balance FROM (`Customer` INNER JOIN `Customer/LoanAccount` 
        ON Customer.customerNo = `Customer/LoanAccount`.`customerNo`) INNER JOIN `Loan Account` ON `Loan Account`.`accountID` = 
        `Customer/LoanAccount`.`accountID` WHERE Customer.deletedFlag = 0 AND `Loan Account`.`deletedFlag` = 0;";

// check if query is successful
if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

// if customerId is not null, get the value, otherwise set it to empty string
// do the same for account number
$selectedCust = $_SESSION['close_customerID'] ?? '';
$selectedAcc = $_SESSION['close_AccountNumber'] ?? '';

// create dropdown
echo "<option value='placeholder'>Select a customer</option>";

// loop through the result and create an option for each customer
while ($row = mysqli_fetch_array($result)) {
    // get the values from the row
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $phone = $row["telephoneNo"];
    $accountNo = $row["accountNumber"];
    $balance = $row["balance"];
    $name = $fname . " " . $lname . " : " . $accountNo;
    // create a string with all the values
    $allText = "$id#$addr#$eircode#$dob#$phone#$accountNo#$balance";

    // if the selected customer from the session is the same as the current 
    //    customer, set the selected attribute to selected, else set it to empty string
    $selected = (($id == $selectedCust) && ($accountNo == $selectedAcc)) ? "selected" : "";
    echo "<option value='$allText' $selected>$name</option>";
}
// close connection
mysqli_close($con);
