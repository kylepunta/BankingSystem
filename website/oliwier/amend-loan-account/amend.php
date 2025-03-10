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

include 'db.inc.php';      // include db connection file
date_default_timezone_set("UTC");       // set default timezone
echo "The details sent down are: <br>";     

// confirm the data being sent to the db
echo "Customer ID is :" . $_SESSION['customerID'] . "<br>";
echo "Account Number is :" . $_SESSION['closeAccountNumber'] . "<br>";
echo "Term is :" . $_POST['term'] . "<br>";
echo "Loan Ammount is :" . $_POST['loanAmount'] . "<br>";
echo "Repayments is :" . $_SESSION['repayments'] . "<br>";

// prepare the sql statement for inserting the values
$sql = "UPDATE `Loan Account` SET loanTerm='$_POST[term]' , loanAmount='$_POST[loanAmount]' WHERE accountNumber = '$_SESSION[closeAccountNumber]'";

// check if any errors in the sql have occured
if (!mysqli_query($con,$sql)) {
    die ("An error in the sql query: " . mysqli_error($con));
}
  
//close connection
mysqli_close($con);

session_destroy();      // destroy the session
UNSET($_SESSION);       // unset the session
?>

<!-- form to send you back to the submit page -->
<form action = "index.php" method = "POST" >
    <br>
    <input type="submit" value = "Return to amend Page"/>
</form>
