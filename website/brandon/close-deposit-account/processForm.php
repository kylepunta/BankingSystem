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

	$_SESSION['number'] = $_POST['number'];

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
		unset ($_SESSION['closecustNumber']);
		unset ($_SESSION['closename']);
		unset ($_SESSION['closeaddress']);
		unset ($_SESSION['closeeircode']);
		unset ($_SESSION['closedob']);
		unset ($_SESSION['closeaccNumber']);
		unset ($_SESSION['closebalance']);
	} 

	mysqli_close($con);
	header('Location: ./');
?>