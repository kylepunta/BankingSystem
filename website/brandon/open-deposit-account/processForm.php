<?php 
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");
	$sql = "SELECT * FROM Customer WHERE customerNo='".$_POST['number'] . "' AND deletedFlag='0'";

	if (!$result = mysqli_query($con, $sql)) {
		die('Error in querying the database ' . mysqli_error($con));
	}

	$rowcount = mysqli_affected_rows($con);

	$_SESSION['number'] = $_POST['number'];

	if ($rowcount == 1) {
		$row = mysqli_fetch_array($result);		
		$_SESSION['name'] = $row['firstName'] . " " . $row['surName'];
		$_SESSION['address'] = $row['address'];
		$_SESSION['eircode'] = $row['eircode'];
		$_SESSION['dob'] = $row['dateOfBirth'];
	} else if ($rowcount == 0) {
		unset ($_SESSION['name']);
		unset ($_SESSION['address']);
		unset ($_SESSION['eircode']);
		unset ($_SESSION['dob']);
		mysqli_close($con);
		header('Location: ./');
	} 
	if (isset($_POST['confirmDetails'])) {
		$valid = false;
		while (!$valid) {
			// generate a random 8 digit account number
			$accountNo = rand(10000000, 99999999);

			$sql = "SELECT accountNumber FROM `Deposit Account` WHERE accountNumber=" . $accountNo . " UNION SELECT accountNumber FROM `Loan Account` WHERE accountNumber=" . $accountNo . " UNION SELECT accountNumber FROM `Current Account` WHERE accountNumber=" . $accountNo;

			if (!$result = mysqli_query($con, $sql)) {
				die('Error in querying the database ' . mysqli_error($con));
			}

			$rowCount = mysqli_affected_rows($con);

			if ($rowCount == 0) {
				$valid = true;
				$_SESSION['accNo'] = $accountNo;
				$_SESSION['number'] = $_POST['number'];
				$_SESSION['name'] = $_POST['name'];
				$_SESSION['address'] = $_POST['address'];
				$_SESSION['eircode'] = $_POST['eircode'];
				$_SESSION['dob'] = $_POST['dob'];
			}
		}
	}
	mysqli_close($con);
	header('Location: ./');
?>