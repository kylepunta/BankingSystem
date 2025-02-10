<?php 
    session_start();
    require '../../db.inc.php';

	$sql = "SELECT * FROM Customer WHERE customerNo = '".$_POST['custNo'] . "'";

    if (!$result = mysqli_query($con, $sql)) {
        die('Error in querying the database ' . mysqli_error($con));
    }

    $rowcount = mysqli_affected_rows($con);

    $_SESSION['custNo'] = $_POST['custNo'];

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