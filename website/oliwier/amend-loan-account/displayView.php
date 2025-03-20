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
$sql = "SELECT Customer.customerNo, firstName, surName, address, eircode, dateOfBirth, 
        telephoneNo, `Loan Account`.`accountNumber`, `Loan Account`.accountID, `Loan Account`.balance, 
        `Loan Account`.`loanMonthlyRepayments`, `Loan Account`.`loanTerm`, `Loan Account`.`loanAmount` FROM 
        (`Customer` INNER JOIN `Customer/LoanAccount` ON Customer.customerNo = `Customer/LoanAccount`.`customerNo`) 
        INNER JOIN `Loan Account` ON `Loan Account`.`accountID` = `Customer/LoanAccount`.`accountID` 
        WHERE Customer.customerNo = " . $_POST['custID'] . " AND `Loan Account`.`accountNumber` = " . $_POST['AccountNumber'] . ";";

// check if any errors occurred in the query
if (!$result = mysqli_query($con, $sql)) {
    die('Error in querying the database' . mysqli_error($con));
}

// get the number of rows
$rowcount = mysqli_affected_rows($con);

// set session 'personid' as personid from the Post
$_SESSION['amend_customerID'] = $_POST['custID'];

// set session 'personid' as personid from the Post
$_SESSION['amend_AccountNumber'] = $_POST['AccountNumber'];

// if theres one rowcount then a record has been found
if ($rowcount == 1) {
    // fetch associative array from the query
    $row = mysqli_fetch_array($result);

    // set all session variables as the fetched values from the table
    $_SESSION['amend_customerID'] = $row['customerNo'];
    $_SESSION['amend_name'] = $row['firstName'];
    $_SESSION['amend_address'] = $row['address'];
    $_SESSION['amend_eircode'] = $row['eircode'];
    $_SESSION['amend_dob'] = $row['dateOfBirth'];
    $_SESSION['amend_phone'] = $row['telephoneNo'];
    $_SESSION['amend_AccountNumber'] = $row['accountNumber'];
    $_SESSION['amend_balance'] = $row['balance'];
    $_SESSION['amend_repayments'] = $row['loanMonthlyRepayments'];
    $_SESSION['amend_term'] = $row['loanTerm'];
    $_SESSION['amend_amount'] = $row['loanAmount'];
    $_SESSION['amend_accountConfirmed'] = true;

} else if ($rowcount == 0) {  // if no record found unset all session variables
    unset($_SESSION['amend_name']);
    unset($_SESSION['amend_dob']);
    unset($_SESSION['amend_address']);
    unset($_SESSION['amend_eircode']);
    unset($_SESSION['amend_dob']);
    unset($_SESSION['amend_phone']);
    unset($_SESSION['amend_balance']);
    unset($_SESSION['amend_accountConfirmed']);
    unset($_SESSION['amend_repayments']);
    unset($_SESSION['amend_term']);
    unset($_SESSION['amend_amount']);
    unset($_SESSION['amend_accountConfirmed']);
}


// close connection
mysqli_close($con);
//Go back to the calling form with the values that we need to display in session variables, if a record was found 
header('Location: index.php');

?>