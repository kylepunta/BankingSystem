<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Account Number Generator */
function generateAccountNo()
{
    include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';
    // loops until continueLoop is false (a safe account number was generated)
    $continueLoop = true;
    while ($continueLoop) {
        // generate a random 8 digit account number
        $accountNo = rand(10000000, 99999999);

        // queries each account type for an account matching the given account number
        $sql = "SELECT accountNumber FROM `Deposit Account` WHERE accountNumber = $accountNo
        UNION SELECT accountNumber FROM `Loan Account` WHERE accountNumber = $accountNo
        UNION SELECT accountNumber FROM `Current Account` WHERE accountNumber = $accountNo";

        // run the query for each account type
        $result = mysqli_query($con, $sql);

        // checks that the sql query was successful
        if (!$result) {
            // displays the error that caused the query to fail
            // exits the script
            die("An error in the SQL Query: " . mysqli_error($con));
        }

        // counts the number of accounts with the given account number
        $numOfAccounts = mysqli_num_rows($result);

        // checks if the account number exists on any other account type
        if ($numOfAccounts == 0) {
            // this account number is safe
            $continueLoop = false;
        }
    }

    // closes the connection
    mysqli_close($con);

    // sends the accountNo
    return $accountNo;
}
