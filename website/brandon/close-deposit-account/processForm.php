<?php 
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");
	$sql = "SELECT firstName, surName, address, eircode, dateOfBirth, Customer.customerNo, accountNumber, balance 
	FROM (Customer INNER JOIN `Customer/Deposit Account` ON Customer.customerNo = `Customer/Deposit Account`.`customerNo`) 
	INNER JOIN `Deposit Account` ON `Customer/Deposit Account`.`accountID` = `Deposit Account`.`accountID` 
	WHERE Customer.deletedFlag=0 AND `Deposit Account`.`deletedFlag`=0 
	AND Customer.customerNo='$_POST[custNumber]' AND accountNumber='$_POST[accNumber]'";

	if (!$result = mysqli_query($con, $sql)) {
		die('Error in querying the database ' . mysqli_error($con));
	}

	$rowcount = mysqli_affected_rows($con);

	if ($rowcount == 1) {
		$row = mysqli_fetch_array($result);
		$_SESSION['closecustNumber'] = $row['customerNo'];
        $_SESSION['closename'] = $row['firstName'] . " " . $row['surName'];
        $_SESSION['closeaddress'] = $row['address'];
        $_SESSION['closeeircode'] = $row['eircode'];
        $dob = date_create($row['dateOfBirth']);
        $dob = date_format($dob,"Y-m-d");
		$_SESSION['closedob'] = $dob;
        $_SESSION['closeaccNumber'] = $row['accountNumber'];
        $_SESSION['closebalance'] = $row['balance'];
	} else if ($rowcount == 0) {
		$_SESSION['closecustNumber'] = $_POST['custNumber']; // for error message purposes
		$_SESSION['closeaccNumber'] = $_POST['accNumber']; 
		unset ($_SESSION['closename']);
		unset ($_SESSION['closeaddress']);
		unset ($_SESSION['closeeircode']);
		unset ($_SESSION['closedob']);
		unset ($_SESSION['closebalance']);
		mysqli_close($con);
		header('Location: ./');
	} 
	if (isset($_POST['deleteCustomer'])) {
		$sql = "UPDATE `Deposit Account` SET deletedFlag=1 WHERE accountNumber='$_POST[accNumber]'";
		if (!$result = mysqli_query($con, $sql)) {
			die('Error in querying the database ' . mysqli_error($con));
		}
		mysqli_close($con);
		echo "Deposit account closed successfully!";
		?>
		<form action="./">
    		<input type="submit" value="Return to previous page"/>
		</form>
		<?php
	} else {
		mysqli_close($con);
		header('Location: ./');
	}
?>