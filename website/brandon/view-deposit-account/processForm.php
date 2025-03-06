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
		$_SESSION['viewcustNumber'] = $row['customerNo'];
        $_SESSION['viewname'] = $row['firstName'] . " " . $row['surName'];
        $_SESSION['viewaddress'] = $row['address'];
        $_SESSION['vieweircode'] = $row['eircode'];
        $dob = date_create($row['dateOfBirth']);
        $dob = date_format($dob,"Y-m-d");
		$_SESSION['viewdob'] = $dob;
        $_SESSION['viewaccNumber'] = $row['accountNumber'];
        $_SESSION['viewbalance'] = $row['balance'];
	} else if ($rowcount == 0) {
		$_SESSION['viewcustNumber'] = $_POST['custNumber']; // for error message purposes
		$_SESSION['viewaccNumber'] = $_POST['accNumber']; 
		unset ($_SESSION['viewname']);
		unset ($_SESSION['viewaddress']);
		unset ($_SESSION['vieweircode']);
		unset ($_SESSION['viewdob']);
		unset ($_SESSION['viewbalance']);
	} 

	mysqli_close($con);
	header('Location: ./');
?>