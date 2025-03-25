<!--
Name: Oliwier Jakubiec
Date: 13/2/2025
ID : C00296807
Title: display view php
    -->
<?php
// start session
session_start();
include '../../db.inc.php';      // include DB access file

// prepare sql statement
$sql = "SELECT Customer.customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo, 
        `Loan Account`.`accountNumber`, `Loan Account`.accountID, `Loan Account`.balance FROM (`Customer` INNER JOIN `Customer/LoanAccount` 
        ON Customer.customerNo = `Customer/LoanAccount`.`customerNo`) INNER JOIN `Loan Account` ON `Loan Account`.`accountID` = 
        `Customer/LoanAccount`.`accountID` WHERE `Loan Account`.`accountNumber` = " . $_POST['closeAccountNumber'] . ";";

// check if any errors occurred in the query
if (!$result = mysqli_query($con, $sql)) {
    die('Error in querying the database' . mysqli_error($con));
}

// get the number of rows
$rowcount = mysqli_affected_rows($con);

// set session 'personid' as personid from the Post
$_SESSION['close_AccountNumber'] = $_POST['closeAccountNumber'];

// if theres one rowcount then a record has been found
if ($rowcount == 1) {
    // fetch associative array from the query
    $row = mysqli_fetch_array($result);

    // set all session variables as the fetched values from the table
    $_SESSION['close_customerID'] = $row['customerNo'];
    $_SESSION['close_loanname'] = $row['firstName'];
    $_SESSION['close_address'] = $row['address'];
    $_SESSION['close_eircode'] = $row['eircode'];
    $_SESSION['close_dob'] = $row['dateOfBirth'];
    $_SESSION['close_phone'] = $row['telephoneNo'];
    $_SESSION['close_AccountNumber'] = $row['accountNumber'];
    $_SESSION['close_balance'] = $row['balance'];
    $_SESSION['close_accountConfirmed'] = true;

} else if ($rowcount == 0) {  // if no record found unset all session variables
    unset($_SESSION['close_customerID']);
    unset($_SESSION['close_loanname']);
    unset($_SESSION['close_dob']);
    unset($_SESSION['close_address']);
    unset($_SESSION['close_eircode']);
    unset($_SESSION['close_dob']);
    unset($_SESSION['close_phone']);
    unset($_SESSION['close_balance']);
    unset($_SESSION['close_accountConfirmed']);

}


// close connection
mysqli_close($con);
//Go back to the calling form with the values that we need to display in session variables, if a record was found 
header('Location: index.php');

?>