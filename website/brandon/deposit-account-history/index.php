<?php session_start(); ?>
<!-- Name: Brandon Jaroszczak 
Student ID: C00296052 
Month: March 2025 
Purpose: main HTML page for deposit account history -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Account History</title>
    <!-- Import head styles with PHP -->
    <?php require('../../head.html') ?>
    <!-- CSS and javascript used by this file only -->
    <link rel="stylesheet" href="../brandonStyles.css">
    <script src="./script.js"></script>
</head>
<!-- When body is loaded run the populate() function -->

<body onload="populate()">
    <!-- Load in sidemenu with PHP -->
    <?php require('../../sideMenu.html'); ?>
    <main>
        <!-- Main form -->
        <form action="processForm.php" method="post" id="customerDetailsForm" onsubmit="return checkDates()">
            <h1>Deposit account history</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <!-- Load in dropdown selection with PHP -->
                <?php require('./dropdownBox.php') ?>
            </div>
            <!-- 2 form fields with validation to manually enter customer/account numbers -->
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (isset($_SESSION['historycustNumber'])) echo $_SESSION['historycustNumber'] ?>" />
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (isset($_SESSION['historyaccNumber'])) echo $_SESSION['historyaccNumber'] ?>" />
            </div>
            <!-- Start date and end date fields if the user wishes to optionally choose a start date, end date or both -->
            <div class="inputbox">
                <label for="startDate">Start date (optional):</label>
                <input type="date" name="startDate" id="startDate" value="<?php if (isset($_SESSION['startDate'])) echo $_SESSION['startDate'] ?>" />
            </div>
            <div class="inputbox">
                <label for="endDate">End date (optional):</label>
                <input type="date" name="endDate" id="endDate" value="<?php if (isset($_SESSION['endDate'])) echo $_SESSION['endDate'] ?>" />
            </div>
            <!-- Customer name field to be populated with PHP or javascript -->
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly value="<?php if (isset($_SESSION['endDate'])) echo $_SESSION['endDate'] ?>" />
            </div>
            <!-- Submit button to submit form -->
            <div class="buttons">
                <input type="submit" value="Check transactions" id="chooseCustomerButton" name="checkDetails">
            </div>
        </form>
        <?php
        // if manually entered customer/account numbers are incorrect display error message and destroy session
        if (!isset($_SESSION['historyname']) and isset($_SESSION['historycustNumber'])) {
            echo '<p id="errorMessage">No account found with customer no: ' . $_SESSION['historycustNumber'] . ' and account no: ' . $_SESSION['historyaccNumber'] . '!<br>Please try again!</p>';
            session_destroy();
        } else {
            // if historyname field was set (i.e. form was submitted earlier) run script
            if (isset($_SESSION['historyname'])) {
                // include DB connection
                require '../../db.inc.php';
                date_default_timezone_set("UTC");

                // query to select account ID from inputted account number
                $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber='$_SESSION[historyaccNumber]'";

                if (!$result = mysqli_query($con, $sql)) {
                    die('Error in querying the database ' . mysqli_error($con));
                }

                $row = mysqli_fetch_array($result);
                // store account ID
                $accID = $row['accountID'];

                // check which date fields had data and add WHERE to the SQL query below
                // if both date fields had data
                if (isset($_SESSION['startDate']) && isset($_SESSION['endDate'])) {
                    $dateSQL = "AND date>='$_SESSION[startDate]' AND date<='$_SESSION[endDate]'";
                } else if (isset($_SESSION['startDate'])) {
                    // if only start date had data
                    $dateSQL = "AND date>='$_SESSION[startDate]'";
                } else if (isset($_SESSION['endDate'])) {
                    // if only end date had data
                    $dateSQL = "AND date<='$_SESSION[endDate]'";
                } else {
                    // if none of the dates had data
                    $dateSQL = "";
                }

                // sql query to select all transaction for this account ID with optional date filtering
                $sql = "SELECT * FROM `Deposit Account History` WHERE accountID='$accID' $dateSQL ORDER BY `Deposit Account History`.`date` DESC, transactionId DESC";

                if (!$result = mysqli_query($con, $sql)) {
                    die('Error in querying the database ' . mysqli_error($con));
                }

                if (mysqli_affected_rows($con) == 0) {
                    // if no transactions found display message
                    echo "<p id='message'>No transactions found within the selected time frame.<br>Please try with different dates</p>";
                } else {
                    // if transactions found display table of transactions
                    echo "<h2>Transactions:</h2><table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        $date = date_create($row['date']);
                        $date = date_format($date, "d-m-Y");
                        echo "<tr><td>" . $date . "</td><td>" . $row['transactionType'] . "</td><td>" . $row['transactionAmount'] . "</td><td>" . $row['balance'] . "</td></tr>";
                    }
                    echo "</tbody></table>";
                }
                // close connection and destroy session
                mysqli_close($con);
                session_destroy();
            }
        }
        ?>
    </main>
</body>

</html>