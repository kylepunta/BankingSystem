<!--
Name: Oliwier Jakubiec
Date: 30/1/2025
ID : C00296807
Title: insert page php
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
    <link rel="stylesheet" href="close.css">
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
    echo "Customer ID is :" . $_SESSION['customerID'] . "<br>";
    echo "Account Number is :" . $_SESSION['loanaccountNumber'] . "<br>";
    echo "Term is :" . $_SESSION['term'] . "<br>";
    echo "Loan Ammount is :" . $_SESSION['amount'] . "<br>";
    echo "Repayments is :" . $_POST['repayments'] . "<br>";

    $date=date("Y-m-d");       // create the date object



    // prepare the sql statement for inserting the values
    $sql = "INSERT INTO `Loan Account` (
        accountNumber,
        balance,
        loanAmount,
        loanStartDate,
        loanTerm,
        loanMonthlyRepayments) 
    VALUES ('$_SESSION[loanaccountNumber]', '$_SESSION[amount]', '$_SESSION[amount]','$date','$_SESSION[term]','$_POST[repayments]')";

    // check if any errors in the sql have occured
    if (!mysqli_query($con,$sql)) {
        die ("An error in the sql query: " . mysqli_error($con));
    }

    // create new sql statement to get the new accountID
    $sql = "SELECT accountID FROM `Loan Account` WHERE accountNumber = '$_SESSION[loanaccountNumber]'";

    // check if any errors in the sql have occured
    if (!$result = mysqli_query($con,$sql)) {
        die ('Error in querying the database' . mysqli_error($con));
    }
    // get the accountID
    while ($row = mysqli_fetch_array($result)) {
        $accountID = $row['accountID'];
    }

    // prepare the sql statement for inserting the values into the linking table
    $sql = "INSERT INTO `Customer/LoanAccount` (
        customerNo,
        accountID)"
        . "VALUES ('$_SESSION[customerID]', '$accountID')";

    // check if any errors in the sql have occured
    if (!$result = mysqli_query($con,$sql)) {
        die ('Error in querying the database' . mysqli_error($con));
    }
        
    //close connection
    mysqli_close($con);

    session_destroy();      // destroy the session
    UNSET($_SESSION);       // unset the session
    ?>

    <!-- form to send you back to the submit page -->
    <form action = "index.php" method = "POST" >
        <br>
        <input type="submit" value = "Return to Insert Page"/>
    </form>
</main>