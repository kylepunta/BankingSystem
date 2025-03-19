<!--
Name: Oliwier Jakubiec
Date: 30/1/2025
ID : C00296807
Title: amend page php
    -->

<?php
session_start();        // start session
?>
<!DOCTYPE html>

<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <!-- important css stuff for the sidemenu -->
    <?php require('../../head.html') ?>
    <!-- css file -->
    <link rel="stylesheet" href="amend.css">
    <!-- javascript file -->
    <script src="script.js"></script>
</head>

<?php
// include sidemenu
require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
?>
<main>
    <?php
    include 'db.inc.php';      // include db connection file
    date_default_timezone_set("UTC");       // set default timezone
    echo "The details sent down are: <br>";

    // confirm the data being sent to the db
    echo "Customer ID is :" . $_SESSION['amend_customerID'] . "<br>";
    echo "Account Number is :" . $_SESSION['amend_AccountNumber'] . "<br>";
    echo "Term is :" . $_POST['term'] . "<br>";
    echo "Loan Ammount is :" . $_POST['loanAmount'] . "<br>";
    echo "Repayments is :" . $_SESSION['amend_repayments'] . "<br>";

    // prepare the sql statement for updating the values
    $sql = "UPDATE `Loan Account` SET loanTerm='$_POST[term]' , loanAmount='$_POST[loanAmount]' WHERE accountNumber = '$_SESSION[amend_AccountNumber]'";

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
        <input type="submit" value="Return to amend Page" />
    </form>
</main>