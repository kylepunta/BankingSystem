<!--
Name: Oliwier Jakubiec
Date: 30/1/2025
ID : C00296807
Title: insert page php
	-->

<?php
session_start();        // start session
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="/commonStyles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<?php
require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
?>
<main>
<?php
include 'db.inc.php';      // include db connection file
date_default_timezone_set("UTC");       // set default timezone
echo "The details sent down are: <br>";     

// confirm the data being sent to the db
echo "Customer ID is :" . $_SESSION['customerID'] . "<br>";
echo "Account Number is :" . $_SESSION['loanaccountNumber'] . "<br>";
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
VALUES ('$_SESSION[loanaccountNumber]', '$_SESSION[amount]', '$_SESSION[amount]','$date','$_SESSION[term]','$_POST[repayments]')";

// check if any errors in the sql have occured
if (!mysqli_query($con,$sql)) {
    die ("An error in the sql query: " . mysqli_error($con));
}

$sql = "SELECT accountID FROM `Loan Account` WHERE accountNumber = '$_SESSION[loanaccountNumber]'";

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
</main>