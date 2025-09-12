<?php
session_start();
// Name: Brandon Jaroszczak //
// Student ID: C00296052 //
// Month: February 2025 //
// Purpose: PHP script that is run when form 2/2 is submitted in open deposit account //
require '../../db.inc.php';
date_default_timezone_set("UTC");

// If the "Create deposit account" button was clicked to submit the form
if (isset($_POST['submitCustomer'])) {
    // Insert new deposit account into DB
    $sql = "INSERT INTO `Deposit Account` (`accountNumber`, `balance`, `deletedFlag`) VALUES ('$_POST[accNo]', '$_POST[balance]', '0')";

    if (!mysqli_query($con, $sql)) {
        die("An error in the SQL query: " . mysqli_error($con));
    }

    // Retrieve the accountID primary key from database from the account that was just added
    $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber='$_POST[accNo]'";

    if (!$result = mysqli_query($con, $sql)) {
        die('Error in querying the database ' . mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);
    // Store the account ID
    $accID = $row['accountID'];

    // Insert new deposit account linked to existing customer into this table, this allows a single customer to have multiple accounts
    $sql = "INSERT INTO `Customer/Deposit Account` (`customerNo`, `accountID`) VALUES ('$_SESSION[number]', '$accID')";

    if (!mysqli_query($con, $sql)) {
        die("An error in the SQL query: " . mysqli_error($con));
    }

    // Create a new date object with no parameters, this makes it the current date and time
    $date = date_create();
    // Format the date so its compatible with the database
    $date = date_format($date, 'Y-m-d');
    // Insert opening account as a lodgement transaction into the transactions table
    $sql = "INSERT INTO `Deposit Account History` (`accountId`, `date`, `transactionType`, `transactionAmount`, `balance`) VALUES ('$accID', '$date', 'Lodgement', '$_POST[balance]', '$_POST[balance]')";

    if (!mysqli_query($con, $sql)) {
        die("An error in the SQL query: " . mysqli_error($con));
    }
    // Print confirmation message
    echo "Deposit account opened successfully";
} else {
    // If the reset button was clicked, the form is submitted using javascript and it goes straight here
    // Destroy the session clearing all fields and generated account numbers
    session_destroy();
    // Redirect back to previous page
    header('Location: ./');
}
// Close connection and destroy session, this data is no longer needed
mysqli_close($con);
session_destroy();
?>

<!-- Include a back button to return to previous page -->
<form action="./">
    <input type="submit" value="Return to previous page" />
</form>