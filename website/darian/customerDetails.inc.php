<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details */
// we're doing database operations, require that file
require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
// declares that these variables are from another file and globally available
global $con;
global $validId;

// default to false
$validId = false;

// stores the SQL statement to be queried later
// selects a customers details, makes sure they aren't deleted
// if no customer number is POSTed, the customer number 0 is selected which doesn't belong to any customer therefore no customer is selected
$sql = "SELECT address, eircode, dateOfBirth FROM Customer
WHERE deletedFlag = 0 AND Customer.customerNo = " . (!empty($_POST["cid"]) ? "$_POST[cid]" : "0");

// checks that the sql query was successful
if (!$result = mysqli_query($con, $sql)) {
    // displays the error that caused the query to fail
    // exits the script
    die("An error in the SQL Query: " . mysqli_error($con));
}

// checks that only one account was queried
if (mysqli_num_rows($result) == 1) {
    // sets the valid customer to true so that other pieces of code can run elsewhere
    $validId = true;

    // gets the row from the result
    $row = mysqli_fetch_array($result);
    // stores the values in the row
    $_SESSION["address"] = $row["address"];
    $_SESSION["eircode"] = $row["eircode"];
    $_SESSION["dob"] = $row["dateOfBirth"];
} else {
    // clears the values before they are displayed on the form
    unset($_SESSION["address"]);
    unset($_SESSION["eircode"]);
    unset($_SESSION["dob"]);
    // sends an error message to display to the user
    $_SESSION["errorMsg"] .= "No record found for customer number: $_POST[cid]<br>Please try again!<br>";
}

// closes the connection
mysqli_close($con);
