<?php 
	session_start();
    require '../../db.inc.php'; // database connection
    date_default_timezone_set('UTC');

    // set and execute query
    $sql = "SELECT * FROM Customer WHERE DeletedFlag=0";

    if (!$result = mysqli_query($con, $sql)) {
        die ('Error in querying the database ' . mysqli_error($con));
    }

	$selectedCustomer = $_SESSION['number'] ?? ''; // Retrieve stored number or empty string
    echo "<select name='listbox' id='listbox' onclick='populate()'>";

    // load in values from database and into the select dropdown
    while ($row = mysqli_fetch_array($result)) {
        $customerNo = $row['customerNo'];
        $fullName = $row['firstName'] . " " . $row['surName'];
        $address = $row['address'];
        $eircode = $row['eircode'];
        $dob = date_create($row['dateOfBirth']);
        $dob = date_format($dob,"Y-m-d");
        $allText = "$customerNo ¬$fullName ¬$address ¬$eircode ¬$dob"; // ¬ has to be used as addresses may contain a , inside them breaking the string
		
		// Check if the current customer should be selected
    	$selected = ($customerNo == $selectedCustomer) ? "selected" : "";
		
        echo "<option value='$allText' $selected>$fullName</option>";
    }
    echo "</select>";
    mysqli_close($con);
?>