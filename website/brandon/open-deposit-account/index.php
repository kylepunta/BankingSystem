<!-- Name: Brandon Jaroszczak -->
<!-- Student ID: C00296052 -->
<!-- Month: February 2025 -->
<!-- Purpose: main HTML page for add deposit account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Deposit Account</title>
    <!-- Common stylsheets imported with php -->
    <?php require('../../head.html') ?>
    <!-- Stylesheets and script for this page -->
    <!-- <link rel="stylesheet" href="../brandonStyles.css"> -->
    <script src="./script.js"></script>
</head>
<!-- Onload used to enable/disable form fields based on the current state of the webpage -->

<body onload="toggleInputs()">
    <!-- Import sidemenu using php -->
    <?php require('../../sideMenu.html'); ?>
    <main>
        <!-- Form 1/2 for customer details -->
        <!-- Fields with ISSET are set using php from data gathered from session variables -->
        <form id="open-deposit-form" action="processForm.php" method="post" onsubmit="return confirmSubmit()" class="upperForm">
            <h1>Open a deposit account</h1>
            <div class="inputbox">
                <label>Choose a customer:</label>
                <!-- Dropdown box added with php -->
                <?php require('./dropdownBox.php') ?>
            </div>
            <!-- Field to manually input a customer number with validation only digits are allowed -->
            <div class="inputbox">
                <label for="number">Customer number:</label>
                <input type="text" name="number" id="number" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (isset($_SESSION['number'])) echo $_SESSION['number'] ?>" />
            </div>
            <!-- Submit button for manually checking customer numbers -->
            <div class="buttons check-customer-details">
                <input type="submit" value="Check customer details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <!-- Form fields to be automatically filled in with PHP or javascript -->
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (isset($_SESSION['name'])) echo $_SESSION['name'] ?>" title="Please choose a customer by name or id above" />
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (isset($_SESSION['address'])) echo $_SESSION['address'] ?>" />
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (isset($_SESSION['eircode'])) echo $_SESSION['eircode'] ?>" />
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (isset($_SESSION['dob'])) echo $_SESSION['dob'] ?>" />
            </div>
            <div class="buttons">
                <!-- Submit button to confirm customer details to continue -->
                <input type="submit" value="Confirm details" id="confirmCustomerButton" name="confirmDetails">
            </div>
        </form>
        <!-- Form 2/2 for creating a deposit account -->
        <form id="open-deposit-form-two" action="addCustomer.php" method="post" onsubmit="return finalCheck()" class="lowerForm" id="lowerForm">
            <div class="inputbox">
                <label for="accNo">Generated account no:</label>
                <input type="text" name="accNo" id="accNo" readonly required value="<?php if (isset($_SESSION['accNo'])) echo $_SESSION['accNo'] ?>" title="Please confirm customer details to generate an account no" />
            </div>
            <div class="inputbox">
                <label for="balance">Opening balance:</label>
                <!-- Opening balance can only be a numerical value with exactly 2 decimal places -->
                <input type="text" name="balance" id="balance" disabled required pattern="[0-9]+[.][0-9]{2}" title="Number must match format XX.XX" />
            </div>
            <div class="buttons">
                <!-- Submit button for creating new deposit account -->
                <input type="submit" value="Create account" id="submitCustomer" name="submitCustomer" disabled>
                <!-- Reset button to reset all progress and clear all fields -->
                <input type="reset" value="Cancel" id="clearButton" disabled onclick="resetPage()">
            </div>
        </form>
        <!-- Error message to be displayed if manually entered customer ID does not exist -->
        <?php
        if (!isset($_SESSION['name']) and isset($_SESSION['number'])) {
            echo '<p id="errorMessage">No record found for customer id: ' . $_SESSION['number'] . '<br>Please try again!</p>';
            session_destroy();
        } ?>
    </main>
</body>

</html>