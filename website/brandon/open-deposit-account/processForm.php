<!-- Name: Brandon Jaroszczak -->
<!-- Student ID: C00296052 -->
<!-- Month: February 2025 -->
<!-- Purpose: PHP script that is run when form 1/2 is submitted in open deposit account -->
<?php 
	// Start session and import DB connection
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");

	// Select all non deleted customers with a passed in customer number
	$sql = "SELECT * FROM Customer WHERE customerNo='".$_POST['number'] . "' AND deletedFlag='0'";

	if (!$result = mysqli_query($con, $sql)) {
		die('Error in querying the database ' . mysqli_error($con));
	}

	$rowcount = mysqli_affected_rows($con);

	// Set session number to input
	$_SESSION['number'] = $_POST['number'];

	// If a customer was found set session variables
	if ($rowcount == 1) {
		$row = mysqli_fetch_array($result);		
		$_SESSION['name'] = $row['firstName'] . " " . $row['surName'];
		$_SESSION['address'] = $row['address'];
		$_SESSION['eircode'] = $row['eircode'];
		$_SESSION['dob'] = $row['dateOfBirth'];
	} else if ($rowcount == 0) {
		// If a customer was not found redirect back to previous page where error will be displayed
		unset ($_SESSION['name']);
		unset ($_SESSION['address']);
		unset ($_SESSION['eircode']);
		unset ($_SESSION['dob']);
		// Close and redirect back to page if customer details are invalid or were modified before accepting customer details
		mysqli_close($con);
		header('Location: ./');
	} 
	// If the "Confirm Details" button was pressed run this portion of the script
	if (isset($_POST['confirmDetails'])) {
		$valid = false;
		while (!$valid) {
			// generate a random 8 digit account number
			$accountNo = rand(10000000, 99999999);

			// Select the accountNumber column from all 3 types of accounts database tables
			$sql = "SELECT accountNumber FROM `Deposit Account` WHERE accountNumber=" . $accountNo . " 
			UNION SELECT accountNumber FROM `Loan Account` WHERE accountNumber=" . $accountNo . " 
			UNION SELECT accountNumber FROM `Current Account` WHERE accountNumber=" . $accountNo;

			if (!$result = mysqli_query($con, $sql)) {
				die('Error in querying the database ' . mysqli_error($con));
			}

			// If the randomly generated account number is not present in any table accept the account number, otherwise loop and try again
			if (mysqli_affected_rows($con) == 0) {
				$valid = true;
				$_SESSION['accNo'] = $accountNo;
			}
		}
	}
	// Close and redirect back to page
	mysqli_close($con);
	header('Location: ./');
?>