<?php
session_start();
// Name: Brandon Jaroszczak //
// Student ID: C00296052 //
// Month: March 2025 //
// Purpose: dropdown box for deposit account history //
require '../../db.inc.php'; // database connection
date_default_timezone_set('UTC');

// SQL query to select all non deleted customers and their non deleted deposit accounts 
$sql = "SELECT firstName, surName, Customer.customerNo, accountNumber, balance 
    FROM (Customer INNER JOIN `Customer/Deposit Account` ON Customer.customerNo = `Customer/Deposit Account`.`customerNo`) 
    INNER JOIN `Deposit Account` ON `Customer/Deposit Account`.`accountID` = `Deposit Account`.`accountID` 
    WHERE Customer.deletedFlag=0 AND `Deposit Account`.`deletedFlag`=0;";

if (!$result = mysqli_query($con, $sql)) {
    die('Error in querying the database ' . mysqli_error($con));
}

// if the value of selected customer/account is not null then store it in the variable, otherwise store empty string
// ?? means if $_SESSION is null or doesn't exist then result will be ''
$selectedCustomer = $_SESSION['historycustNumber'] ?? ''; // Retrieve stored number or empty string
$selectedAccount = $_SESSION['historyaccNumber'] ?? '';
echo "<select name='listbox' id='listbox' onchange='populate()'>";

// load in values from database and into the select dropdown
while ($row = mysqli_fetch_array($result)) {
    $customerNo = $row['customerNo'];
    $fullName = $row['firstName'] . " " . $row['surName'];
    $accountNumber = $row['accountNumber'];
    $allText = "$customerNo ¬$fullName ¬$accountNumber";

    // Check if the current customer should be selected
    // If both statements are true then use the value beside the ? otherwise use the value beside : (ternary operator)
    $selected = (($customerNo == $selectedCustomer) && ($accountNumber == $selectedAccount)) ? "selected" : "";

    echo "<option value='$allText' $selected>$fullName: $accountNumber</option>";
}
echo "</select>";
// close connection
mysqli_close($con);
