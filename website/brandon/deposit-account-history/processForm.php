<!-- Name: Brandon Jaroszczak -->
<!-- Student ID: C00296052 -->
<!-- Month: March 2025 -->
<!-- Purpose: PHP script when form is submitted in deposit account history -->
 <?php 
	// Load in session and DB connectivity
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");

	// Select all customers and their deposit accounts where neither are deleted and the customerNo and accountNumber match the entered details
	$sql = "SELECT firstName, surName
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
	$_SESSION['historycustNumber'] = $_POST['custNumber'];
	$_SESSION['historyaccNumber'] = $_POST['accNumber']; 

	// if customer and account found populate session variables
	if ($rowcount == 1) {
		$row = mysqli_fetch_array($result);
        $_SESSION['historyname'] = $row['firstName'] . " " . $row['surName'];
		// if startDate had a value create a date object and store in session
		if ($_POST['startDate'] != "") {
			$startDate = date_create($_POST['startDate']);
			$_SESSION['startDate'] = date_format($startDate, "Y-m-d");
		}
		// if endDate had a valye create a datye object and store in session
		if ($_POST['endDate'] != "") {
			$endDate = date_create($_POST['endDate']);
			$_SESSION['endDate'] = date_format($endDate, "Y-m-d");
		}
	} else if ($rowcount == 0) {
		// if customer and account not found unset session variables
		unset($_SESSION['historyname']);
	} 

	// close connection and redirect to main page
	mysqli_close($con);
	header('Location: ./');
?>