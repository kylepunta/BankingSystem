<?php 
	session_start();
    require '../../db.inc.php'; // database connection
    date_default_timezone_set('UTC');

    $sql = "SELECT firstName, surName, address, eircode, dateOfBirth, Customer.customerNo, accountNumber, balance 
    FROM (Customer INNER JOIN `Customer/Deposit Account` ON Customer.customerNo = `Customer/Deposit Account`.`customerNo`) 
    INNER JOIN `Deposit Account` ON `Customer/Deposit Account`.`accountID` = `Deposit Account`.`accountID` 
    WHERE Customer.deletedFlag=0 AND `Deposit Account`.`deletedFlag`=0;";

    if (!$result = mysqli_query($con, $sql)) {
        die ('Error in querying the database ' . mysqli_error($con));
    }

	$selectedCustomer = $_SESSION['viewcustNumber'] ?? ''; // Retrieve stored number or empty string
    $selectedAccount = $_SESSION['viewaccNumber'] ?? '';
    echo "<select name='listbox' id='listbox' onchange='submitForm()'>";

    // load in values from database and into the select dropdown
    while ($row = mysqli_fetch_array($result)) {
        $customerNo = $row['customerNo'];
        $fullName = $row['firstName'] . " " . $row['surName'];
        $address = $row['address'];
        $eircode = $row['eircode'];
        $dob = date_create($row['dateOfBirth']);
        $dob = date_format($dob,"Y-m-d");
        $accountNumber = $row['accountNumber'];
        $balance = $row['balance'];
        $allText = "$customerNo ¬$fullName ¬$address ¬$eircode ¬$dob ¬$accountNumber ¬$balance"; // ¬ has to be used as addresses may contain a , inside them breaking the string
		
		// Check if the current customer should be selected
    	$selected = (($customerNo == $selectedCustomer) && ($accountNumber == $selectedAccount)) ? "selected" : "";
		
        echo "<option value='$allText' $selected>$fullName: $accountNumber</option>";
    }
    echo "</select>";
    mysqli_close($con);
?>