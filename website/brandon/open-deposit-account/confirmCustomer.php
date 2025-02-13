<?php 
    session_start();
    require '../../db.inc.php';
    date_default_timezone_set("UTC");

    $valid = false;
    while (!$valid) {
        // generate a random 8 digit account number
        $accountNo = rand(10000000, 99999999);

		$sql = "SELECT accountNumber FROM `Deposit Account` WHERE accountNumber=" . $accountNo . " UNION SELECT accountNumber FROM `Loan Account` WHERE accountNumber=" . $accountNo . " UNION SELECT accountNumber FROM `Current Account` WHERE accountNumber=" . $accountNo;

        if (!$result = mysqli_query($con, $sql)) {
            die('Error in querying the database ' . mysqli_error($con));
        }

        $rowCount = mysqli_affected_rows($con);

        if ($rowCount == 0) {
            $valid = true;
            $_SESSION['accNo'] = $accountNo;
        }
    }
    mysqli_close($con);
    header('Location: ./');
?>