<?php 
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");
	$sql = "SELECT firstName, surName, Customer.customerNo, accountNumber
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
		$_SESSION['historycustNumber'] = $row['customerNo'];
        $_SESSION['historyname'] = $row['firstName'] . " " . $row['surName'];
        $_SESSION['historyaccNumber'] = $row['accountNumber'];
		if ($_POST['startDate'] != "") {
			$startDate = date_create($_POST['startDate']);
			$_SESSION['startDate'] = date_format($startDate, "Y-m-d");
		}
		if ($_POST['endDate'] != "") {
			$endDate = date_create($_POST['endDate']);
			$_SESSION['endDate'] = date_format($endDate, "Y-m-d");
		}
	} else if ($rowcount == 0) {
		$_SESSION['historycustNumber'] = $_POST['custNumber']; // for error message purposes
		$_SESSION['historyaccNumber'] = $_POST['accNumber']; 
		unset($_SESSION['historyname']);
	} 

	mysqli_close($con);
	header('Location: ./');
?>