<!-- Name: Brandon Jaroszczak -->
<!-- Student ID: C00296052 -->
<!-- Month: March 2025 -->
<!-- Purpose: main HTML page for view deposit account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Deposit Account</title>
    <!-- Import head styles with PHP -->
    <?php require('../../head.html') ?>
    <!-- Styles and script for this page only -->
    <link rel="stylesheet" href="../brandonStyles.css">
    <script src="./script.js"></script>
</head>
<!-- When body is loaded run the populate() function -->
<body onload="populate()">
    <!-- Load the sidemenu using PHP -->
	<?php require('../../sideMenu.html'); ?>
    <main>
        <!-- Main form element -->
        <form action="processForm.php" method="post" id="customerDetailsForm">
            <h1>View a deposit account</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <!-- Load the dropdown selection using PHP -->
                <?php require('./dropdownBox.php') ?>
            </div>
            <!-- 2 input fields with validation to manually enter the customer and account numbers -->
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['viewcustNumber'])) echo $_SESSION['viewcustNumber'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['viewaccNumber'])) echo $_SESSION['viewaccNumber'] ?>"/>
            </div>
            <div class="buttons">
                <!-- Submit button to check the details of the customer and view transactions -->
                <input type="submit" value="Check details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <!-- Form fields to display customer details populated using PHP or javascript -->
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (ISSET($_SESSION['viewname'])) echo $_SESSION['viewname'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (ISSET($_SESSION['viewaddress'])) echo $_SESSION['viewaddress'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (ISSET($_SESSION['vieweircode'])) echo $_SESSION['vieweircode'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (ISSET($_SESSION['viewdob'])) echo $_SESSION['viewdob'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="balance">Balance:</label>
                <input type="text" name="balance" id="balance" readonly required value="<?php if (ISSET($_SESSION['viewbalance'])) echo $_SESSION['viewbalance'] ?>"/>
            </div>
        </form>
		<?php 
            // If manually entered customer/account details incorrect display error and destroy session
            if (!ISSET($_SESSION['viewname']) and ISSET($_SESSION['viewcustNumber'])) {
                echo '<p id="errorMessage">No account found with customer no: '. $_SESSION['viewcustNumber'] .' and account no: '. $_SESSION['viewaccNumber'] .'!<br>Please try again!</p>';
                session_destroy();
            } else {
                // If viewname is set (i.e. form was submitted earlier) then run this script
                if (ISSET($_SESSION['viewname'])) {
                    // import database connection
                    require '../../db.inc.php';
                    date_default_timezone_set("UTC");

                    // Query to select the accountID that corresponds to the account number submitted earlier
                    $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber='$_SESSION[viewaccNumber]'";
                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }

                    $row = mysqli_fetch_array($result);
                    // store the account ID
                    $accID = $row['accountID'];

                    // Query to get the last 10 transactions from deposit account history in descending order by date, then by transaction ID (if multiple in 1 day the higher transaction ID was made later)
                    $sql = "SELECT * FROM `Deposit Account History` WHERE accountID='$accID' ORDER BY `Deposit Account History`.`date` DESC, transactionId DESC LIMIT 10";

                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }
                    // Display result table
                    echo "<h2>Last 10 transactions</h2>";
                    echo "<table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
                    // display the results in the table
                    while ($row = mysqli_fetch_array($result)) {
                        $date = date_create($row['date']);
                        $date = date_format($date,"d-m-Y");
                        echo "<tr><td>".$date."</td><td>".$row['transactionType']."</td><td>".$row['transactionAmount']."</td><td>".$row['balance']."</td></tr>";
                    }
                    echo "</tbody></table>";
                    // close connection and destroy session
                    mysqli_close($con);
                    session_destroy();
                } else {
                    // if viewname was not set (i.e. form wasn't yet submitted) then submit the form with javascript with the first selected customer from dropdown
                    ?>
                    <script>submitForm();</script>
                    <?php
                }
            }
        ?>
    </main>
</body>
</html>