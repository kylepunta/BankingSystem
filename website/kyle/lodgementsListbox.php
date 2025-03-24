<!--
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A PHP file that renders a list of all current, deposit and loan accounts
-->

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require "../db.inc.php";
date_default_timezone_set("UTC");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accountType'], $_POST['account-dropdown'])) {
    $_SESSION['accountType'] = $_POST['accountType'];
    $_SESSION['selectedAccount'] = $_POST['account-dropdown'];
}

$accountType = isset($_SESSION['accountType']) ? $_SESSION['accountType'] : '';

$sql = "";
switch ($accountType) {
    case "currentAccount":
        $sql = "SELECT `Customer`.`customerNo`, `Customer`.`firstName`, `Customer`.`surName`, `Customer`.`address`, `Customer`.`eircode`, `Customer`.`dateOfBirth`, `Customer`.`telephoneNo`, `Customer`.`occupation`, `Customer`.`salary`, `Customer`.`emailAddress`, `Customer`.`guarantorName`, `Current Account`.`accountId`, `Current Account`.`accountNumber`, `Current Account`.`balance` FROM `Customer/CurrentAccount` INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo`=`Customer`.`customerNo` INNER JOIN `Current Account` ON `Customer/CurrentAccount`.`accountId`=`Current Account`.`accountId` WHERE `Customer`.`deletedFlag`=0";
        break;
    case "depositAccount":
        $sql = "SELECT `Customer`.`customerNo`, `Customer`.`firstName`, `Customer`.`surName`, `Customer`.`address`, `Customer`.`eircode`, `Customer`.`dateOfBirth`, `Customer`.`telephoneNo`, `Customer`.`occupation`, `Customer`.`salary`, `Customer`.`emailAddress`, `Customer`.`guarantorName`, `Deposit Account`.`accountId`, `Deposit Account`.`accountNumber`, `Deposit Account`.`balance` FROM `Customer/Deposit Account` INNER JOIN `Customer` ON `Customer/Deposit Account`.`customerNo`=`Customer`.`customerNo` INNER JOIN `Deposit Account` ON `Customer/Deposit Account`.`accountId`=`Deposit Account`.`accountId` WHERE `Customer`.`deletedFlag`=0";
        break;
    case "loanAccount":
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $sql = "SELECT `Customer`.`customerNo`, `Customer`.`firstName`, `Customer`.`surName`, `Customer`.`address`, `Customer`.`eircode`, `Customer`.`dateOfBirth`, `Customer`.`telephoneNo`, `Customer`.`occupation`, `Customer`.`salary`, `Customer`.`emailAddress`, `Customer`.`guarantorName`, `Loan Account`.`accountId`, `Loan Account`.`accountNumber`, `Loan Account`.`balance`, `Loan Account`.`loanAmount` FROM `Customer/LoanAccount` INNER JOIN `Customer` ON `Customer/LoanAccount`.`customerNo`=`Customer`.`customerNo` INNER JOIN `Loan Account` ON `Customer/LoanAccount`.`accountId`=`Loan Account`.`accountId` WHERE `Customer`.`deletedFlag`=0";
        break;
    default:
        $sql = "SELECT `Customer`.`customerNo`, `Customer`.`firstName`, `Customer`.`surName`, `Customer`.`address`, `Customer`.`eircode`, `Customer`.`dateOfBirth`, `Customer`.`telephoneNo`, `Customer`.`occupation`, `Customer`.`salary`, `Customer`.`emailAddress`, `Customer`.`guarantorName`, `Current Account`.`accountId`, `Current Account`.`accountNumber`, `Current Account`.`balance` FROM `Customer/CurrentAccount` INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo`=`Customer`.`customerNo` INNER JOIN `Current Account` ON `Customer/CurrentAccount`.`accountId`=`Current Account`.`accountId` WHERE `Customer`.`deletedFlag`=0";
        break;
}
// todo delete

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error querying the database" . mysqli_error($con));
}

if (mysqli_num_rows($result) == 0) {
    echo "No rows";
}

while ($row = mysqli_fetch_array($result)) {
    $_SESSION['loanBalance'] = $row['balance'];
    $customerID = $row['customerNo'];
    $firstName = $row['firstName'];
    $lastName = $row['surName'];
    $address = $row['address'];
    $dob = $row['dateOfBirth'];
    $telephone = $row['telephoneNo'];
    $email = $row['emailAddress'];
    $accountID = $row['accountId'];
    $accountNumber = $row['accountNumber'];
    $balance = $row['balance'];
    $values = "$customerID;$accountNumber;$accountID;$balance;$firstName;$lastName;$address;$dob;$telephone;$email";
    $selected = ($_SESSION['selectedAccount'] == $values) ? 'selected' : '';

    echo "<option value='{$values}' {$selected}>{$customerID} - {$firstName} {$lastName} - {$accountNumber}</option>";
}

mysqli_close($con);
