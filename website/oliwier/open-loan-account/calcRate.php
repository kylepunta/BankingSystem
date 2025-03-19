<!--
Name: Oliwier Jakubiec
Date: Feb 2025
ID : C00296807
Title: calculate the loan repayment amount php file
	-->
<?php
    include 'db.inc.php';      // include DB access file
    session_start();           // start session

    // prepare sql statement
    $sql = "SELECT rate FROM `Rate Table` WHERE rateType = 'Interest'";

    // check if any errors occurred in the query
    if (!$result = mysqli_query($con, $sql)) {
        die('Error in querying the database' . mysqli_error($con));
    }

    // get the number of rows
    $rowcount = mysqli_affected_rows($con);

    $row = mysqli_fetch_array($result);
    // get the rate from the row of the rate table
    $rate = $row['rate'];

    // get the term and loan amount from the post
    $term = $_POST['term'];
    $loanAmount = $_POST['loanAmount'];

    // calculate the repay amount
    $repayAmount = $loanAmount / $term;
    $repayAmount *= 1 + $rate;

    // set the session variables
    $_SESSION['amount'] = $loanAmount;
    $_SESSION['term'] = $term;
    $_SESSION['repayAmount'] = $repayAmount;

    //close connection
    mysqli_close($con);

    //Go back to the calling form with the values that we need to display in session variables 
    header('Location: index.php');

?>