<?php
require_once '../../config.php';
?>
<!--
Name: Oliwier Jakubiec
Date: 30/1/2025
ID : C00296807
Title: close page php
    -->
<!DOCTYPE html>

<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Loan Account</title>
    <!-- important css stuff for the sidemenu -->
    <?php require('../../head.html') ?>
    <!-- css file -->
    <link rel="stylesheet" href="../oliwierStyles.css">
    <!-- javascript file -->
    <script src="script.js"></script>
</head>

<?php
// include sidemenu
require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
?>
<main>
    <?php
    include '../../db.inc.php';      // include db connection file
    date_default_timezone_set("UTC");       // set default timezone
    echo "The details sent down are: <br>";

    // confirm the data being sent to the db
    echo "Customer ID is :" . $_SESSION['close_customerID'] . "<br>";
    echo "Account Number is :" . $_SESSION['close_AccountNumber'] . "<br>";

    // prepare the sql statement for closing the account
    $sql = "UPDATE `Loan Account` SET deletedFlag=1 WHERE accountNumber = '$_SESSION[close_AccountNumber]'";

    // check if any errors in the sql have occured
    if (!mysqli_query($con, $sql)) {
        die("An error in the sql query: " . mysqli_error($con));
    }

    //close connection
    mysqli_close($con);

    session_destroy();      // destroy the session
    unset($_SESSION);       // unset the session
    ?>

    <!-- form to send you back to the submit page -->
    <form action="index.php" method="POST">
        <br>
        <input type="submit" value="Return to delete Page" />
    </form>
</main>