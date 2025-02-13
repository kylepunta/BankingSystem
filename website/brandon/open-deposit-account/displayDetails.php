<?php 
	session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");

	$sql = "SELECT * FROM Customer WHERE customerNo='".$_POST['number'] . "'";

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
    } 

    mysqli_close($con);
	header('Location: ./');
?>