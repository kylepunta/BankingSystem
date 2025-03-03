<!--
Name: Oliwier Jakubiec
Date: 30/1/2025
ID : C00296807
Title: insert page php
	-->

<?php
session_start();        // start session

require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');

include 'db.inc.php';      // include db connection file
date_default_timezone_set("UTC");       // set default timezone
echo "The details sent down are: <br>";     

// confirm the data being sent to the db
echo "Customer ID is :" . $_SESSION['customerID'] . "<br>";
echo "Account Number is :" . $_SESSION['accountNumber'] . "<br>";
echo "Term is :" . $_SESSION['term'] . "<br>";
echo "Loan Ammount is :" . $_SESSION['amount'] . "<br>";
echo "Repayments is :" . $_POST['repayments'] . "<br>";

$date=date("Y-m-d");       // create the date object



// prepare the sql statement for inserting the values
$sql = "INSERT INTO `Loan Account` (
    accountNumber,
    balance,
    loanAmount,
    loanStartDate,
    loanTerm,
    loanMonthlyRepayments) 
VALUES ('$_SESSION[accountNumber]', '$_SESSION[amount]', '$_SESSION[amount]','$date','$_SESSION[term]','$_POST[repayments]')";

// check if any errors in the sql have occured
if (!mysqli_query($con,$sql)) {
    die ("An error in the sql query: " . mysqli_error($con));
}

$sql = "SELECT accountID FROM `Loan Account` WHERE accountNumber = '$_SESSION[accountNumber]'";

if (!$result = mysqli_query($con,$sql)) {
    die ('Error in querying the database' . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    $accountID = $row['accountID'];
}


// prepare the sql statement for inserting the values
$sql = "INSERT INTO `Customer/LoanAccount` (
    customerNo,
    accountID)"
    . "VALUES ('$_SESSION[customerID]', '$accountID')";

if (!$result = mysqli_query($con,$sql)) {
    die ('Error in querying the database' . mysqli_error($con));
}    
//close connection
mysqli_close($con);

session_destroy();      // destroy the session
UNSET($_SESSION);       // unset the session
?>

<!-- form to send you back to the submit page -->
<form action = "index.php" method = "POST" >
    <br>
    <input type="submit" value = "Return to Insert Page"/>
</form>
