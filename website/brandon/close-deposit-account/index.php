<!-- Name: Brandon Jaroszczak -->
<!-- Student ID: C00296052 -->
<!-- Month: March 2025 -->
<!-- Purpose: main HTML page for close deposit account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Deposit Account</title>
    <!-- Import head styles using PHP -->
    <?php require('../../head.html') ?>
    <!-- Styles and script used by this page -->
    <link rel="stylesheet" href="../brandonStyles.css">
    <script src="./script.js"></script>
</head>
<!-- Run the populate() function when page loads -->

<body onload="populate()">
    <!-- Load sidemenu using PHP -->
    <?php require('../../sideMenu.html'); ?>
    <main>
        <!-- Main form element -->
        <form id="close-deposit-form" action="processForm.php" method="post" id="customerDetailsForm" onsubmit="return submitCheck()">
            <h1>Close a deposit account</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <!-- Load in dropdown using PHP -->
                <?php require('./dropdownBox.php') ?>
            </div>
            <!-- 2 inputfields to manually enter customer and account numbers, with validation to only allow digits -->
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (isset($_SESSION['closecustNumber'])) echo $_SESSION['closecustNumber'] ?>" />
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (isset($_SESSION['closeaccNumber'])) echo $_SESSION['closeaccNumber'] ?>" />
            </div>
            <div class="buttons check-details-delete-form">
                <!-- Submit button to manually check customer details -->
                <input type="submit" value="Check details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <!-- Fields for the other customer details automatically populated with javascript or PHP -->
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (isset($_SESSION['closename'])) echo $_SESSION['closename'] ?>" />
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (isset($_SESSION['closeaddress'])) echo $_SESSION['closeaddress'] ?>" />
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (isset($_SESSION['closeeircode'])) echo $_SESSION['closeeircode'] ?>" />
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (isset($_SESSION['closedob'])) echo $_SESSION['closedob'] ?>" />
            </div>
            <div class="inputbox">
                <label for="balance">Balance:</label>
                <input type="text" name="balance" id="balance" readonly required value="<?php if (isset($_SESSION['closebalance'])) echo $_SESSION['closebalance'] ?>" />
            </div>
            <!-- p element used to store the "Balance is too high" message -->
            <div class="buttons delete-customer">
                <!-- Submit button to close the account, disabled by default unless balance = 0 -->
                <input type="submit" value="Close account" id="deleteCustomer" name="deleteCustomer" disabled>
            </div>
        </form>
        <p id="message"></p>
        <!-- PHP to display error message if manually entered account details are incorrect -->
        <?php
        if (!isset($_SESSION['closename']) and isset($_SESSION['closecustNumber'])) {
            echo '<p id="errorMessage">No account found with customer no: ' . $_SESSION['closecustNumber'] . ' and account no: ' . $_SESSION['closeaccNumber'] . '!<br>Please try again!</p>';
        }
        // Destroy session after displaying error
        session_destroy();
        ?>
    </main>
</body>

</html>