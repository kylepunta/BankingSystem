<?php 
    session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");

    $sql = "INSERT INTO `Deposit Account` (`accountNumber`, `balance`, `deletedFlag`) VALUES ('" . $_POST['accNo'] . "', '" . $_POST['balance'] . "', '0')";

    if (!mysqli_query($con, $sql)) {
        die ("An error in the SQL query: " . mysqli_error($con));
    }

    $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber=" . $_POST['accNo'];

    if (!$result = mysqli_query($con, $sql)) {
        die('Error in querying the database ' . mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);
    $accID = $row['accountID'];

    $sql = "INSERT INTO `Customer/Deposit Account` (`customerNo`, `accountID`) VALUES ('" . $_SESSION['number'] . "', '" . $accID . "')";
    
    if (!mysqli_query($con, $sql)) {
        die ("An error in the SQL query: " . mysqli_error($con));
    }


    echo "Deposit account opened successfully";

    mysqli_close($con);
    session_destroy();
?>

<form action="./" method="POST">
    <input type="submit" value="Return to insert page"/>
</form>