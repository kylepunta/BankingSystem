<?php
require_once '../../config.php';
// Name: Brandon Jaroszczak //
// Student ID: C00296052 //
// Month: March 2025 //
// Purpose: PHP script to be run when form is submitted in view deposit account //
require '../../db.inc.php';
date_default_timezone_set("UTC");

// Select all customers and their deposit accounts where neither are deleted and the customerNo and accountNumber match the entered details
$sql = "SELECT firstName, surName, address, eircode, dateOfBirth, balance 
	FROM (Customer INNER JOIN `Customer/Deposit Account` ON Customer.customerNo = `Customer/Deposit Account`.`customerNo`) 
	INNER JOIN `Deposit Account` ON `Customer/Deposit Account`.`accountID` = `Deposit Account`.`accountID` 
	WHERE Customer.deletedFlag=0 AND `Deposit Account`.`deletedFlag`=0 
	AND Customer.customerNo='$_POST[custNumber]' AND accountNumber='$_POST[accNumber]'";

if (!$result = mysqli_query($con, $sql)) {
	die('Error in querying the database ' . mysqli_error($con));
}

// get the rowcount
$rowcount = mysqli_affected_rows($con);

// store inputs in session variables
$_SESSION['viewcustNumber'] = $_POST['custNumber'];
$_SESSION['viewaccNumber'] = $_POST['accNumber'];

// if customer and account found populate session variables
if ($rowcount == 1) {
	$row = mysqli_fetch_array($result);
	$_SESSION['viewname'] = $row['firstName'] . " " . $row['surName'];
	$_SESSION['viewaddress'] = $row['address'];
	$_SESSION['vieweircode'] = $row['eircode'];
	$dob = date_create($row['dateOfBirth']);
	$dob = date_format($dob, "Y-m-d");
	$_SESSION['viewdob'] = $dob;
	$_SESSION['viewbalance'] = $row['balance'];
} else if ($rowcount == 0) {
	// if customer and details not found unset session variables
	unset($_SESSION['viewname']);
	unset($_SESSION['viewaddress']);
	unset($_SESSION['vieweircode']);
	unset($_SESSION['viewdob']);
	unset($_SESSION['viewbalance']);
}

// close connection and redirect to main page
mysqli_close($con);
header('Location: ./');
