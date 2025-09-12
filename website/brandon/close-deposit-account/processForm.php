<?php
session_start();
// Name: Brandon Jaroszczak //
// Student ID: C00296052 //
// Month: March 2025 //
// Purpose: PHP script that's executed when the form in close deposit account is submitted //
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
$_SESSION['closecustNumber'] = $_POST['custNumber']; // for error message purposes
$_SESSION['closeaccNumber'] = $_POST['accNumber'];

// if customer and account found populate session variables
if ($rowcount == 1) {
	$row = mysqli_fetch_array($result);
	$_SESSION['closename'] = $row['firstName'] . " " . $row['surName'];
	$_SESSION['closeaddress'] = $row['address'];
	$_SESSION['closeeircode'] = $row['eircode'];
	$dob = date_create($row['dateOfBirth']);
	$dob = date_format($dob, "Y-m-d");
	$_SESSION['closedob'] = $dob;
	$_SESSION['closebalance'] = $row['balance'];
} else if ($rowcount == 0) {
	// if customer and details not found unset session variables
	unset($_SESSION['closename']);
	unset($_SESSION['closeaddress']);
	unset($_SESSION['closeeircode']);
	unset($_SESSION['closedob']);
	unset($_SESSION['closebalance']);
	// close and redirect to main page to display error
	mysqli_close($con);
	header('Location: ./');
}

// if the "Delete account" button was clicked then run the following script
// the checks above were run to double check has the customer/account numbers been changed to invalid before clicking the delete button
if (isset($_POST['deleteCustomer'])) {
	// Update the deleted flag in the relevant customer to 1 to mark the account as deleted
	$sql = "UPDATE `Deposit Account` SET deletedFlag=1 WHERE accountNumber='$_POST[accNumber]'";
	if (!$result = mysqli_query($con, $sql)) {
		die('Error in querying the database ' . mysqli_error($con));
	}
	// Close the connection
	mysqli_close($con);
	// Display confirmation message
	echo "Deposit account closed successfully!";
?>
	<!-- Display return button -->
	<form action="./">
		<input type="submit" value="Return to previous page" />
	</form>
<?php
} else {
	// If "Delete account" button wasn't clicked (i.e. the "Check details" button was clicked) then redirect back after checking details
	mysqli_close($con);
	header('Location: ./');
}
?>