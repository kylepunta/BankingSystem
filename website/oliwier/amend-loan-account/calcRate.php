<?php

include 'db.inc.php';      // include DB access file
session_start();

// prepare sql statement
$sql = "SELECT rate FROM `Rate Table` WHERE rateType = 'Interest'";

// check if any errors occurred in the query
if (!$result = mysqli_query($con,$sql)) {
    die ('Error in querying the database' . mysqli_error($con));
}

// get the number of rows
$rowcount = mysqli_affected_rows($con);

$row = mysqli_fetch_array($result);
$rate = $row['rate'];


$term = $_POST['term'];
$loanAmount = $_POST['loanAmount'];

$repayAmount = $loanAmount / $term;
$repayAmount = $repayAmount * (1 + $rate);

$_SESSION['amount'] = $loanAmount;
$_SESSION['term'] = $term;
$_SESSION['repayAmount'] = $repayAmount;

//close connection
mysqli_close($con);

//Go back to the calling form with the values that we need to display in session variables, if a record was found 
header('Location: index.php' );

?>
