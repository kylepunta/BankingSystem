<!--
Name: Oliwier Jakubiec
Date: Mar 2025
ID : C00296807
Title: main page for close loan account
	-->
<?php session_start(); // start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Loan Account</title>
    <!-- important css stuff for the sidemenu -->
    <?php require('../../head.html') ?>
    <!-- css file -->
    <link rel="stylesheet" href="../oliwierStyles.css">
    <!-- javascript file -->
    <script src="script.js"></script>
</head>

<body>
    <!-- include sidemenu -->
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>

    <main>
    <!-- create form with action displayview and method post 
        this empty form is used for confirming the customer, the fields for it 
        are later in the form for clarity -->
    <form id="checkCustomer" action="displayView.php" method="post"></form>
    
    <!-- main section -->
    <div class="theForm">
        <h1>Close Loan Account</h1>
    <form id="mainForm" action="delete.php" method="post" onsubmit="return confirmCheck()">
        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'name' -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onchange ="return populate()" value="<?php if (ISSET($_SESSION['close_loanname']) ) echo $_SESSION['close_loanname']?>">
                <?php include "listbox.php" ?>
            </select>
        </div>

        <!-- input for customer ID -->
        <!-- on input make sure to disable the submit to confirm which account is being deleted -->
        <div class="inputbox">
            <label for="custID">Customer Number </label>
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off form="checkCustomer" 
            oninput="disableSubmit()" title="Enter a customer number" min="0"
            value="<?php if (ISSET($_SESSION['close_customerID']) ) echo $_SESSION['close_customerID']?>"/>   
        </div>

        <!-- box for account number that is generated -->
        <!-- the text changes depending on the value of the session var 'closeAccountNumber' -->
        <!-- on input make sure to disable the submit to confirm which account is being deleted -->
        <div class="inputbox">
            <label for="closeAccountNumber">Account Number</label>
            <input type="text" name="closeAccountNumber" id="closeAccountNumber" 
            placeholder="10000000" form="checkCustomer" required oninput="disableSubmit()"
            title="Enter the account number as an 8 digit long number" pattern="[\d]{8}"
            value="<?php if (ISSET($_SESSION['close_AccountNumber']) ) echo $_SESSION['close_AccountNumber']?>"/>
        </div>

        <div class="button">
            <!-- submit button -->
            <input type="submit" value="Confirm customer" form="checkCustomer"/>
        </div>
        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'address' -->
        <div class="inputbox">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled 
            value="<?php if (ISSET($_SESSION['close_address']) ) echo $_SESSION['close_address']?>"/>
        </div>

        <!-- box for Last name -->
        <!-- the text changes depending on the value of the session var 'eircode' -->
        <div class="inputbox">
            <label for="eircode">Eircode</label>
            <input type="text" name="eircode" id="eircode" placeholder="eircode" disabled 
                value="<?php if (ISSET($_SESSION['close_eircode']) ) echo $_SESSION['close_eircode']?>" />
            </div>

        <!-- box for date of birth -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <div class="inputbox">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" disabled 
            value="<?php if (ISSET($_SESSION['close_dob']) ) echo $_SESSION['close_dob']?>"/>
        </div>

        <!-- box for customer phone no. -->
        <!-- the text changes depending on the value of the session var 'phone' -->
        <div class="inputbox">
            <label for="phone">Phone number</label>
            <input type="text" name="phone" id="phone" placeholder="phone" disabled
            value="<?php if (ISSET($_SESSION['close_phone']) ) echo $_SESSION['close_phone']?>"/>
        </div>

        <!-- box for loan balance. -->
        <!-- the text changes depending on the value of the session var 'balance' -->
       <div class="inputbox">
        <label for="balance">Loan Balance </label>
            <input type="number" name="balance" id="balance" placeholder="balance" autocomplete=off required form="calcpay"
            form="mainForm" disabled
            value="<?php if (ISSET($_SESSION['close_balance']) ) echo $_SESSION['close_balance']?>"/> 
        </div>

        <!-- submit button -->
        <div class="button">
            <input type="submit" id="submit" value="Close Loan Account" 
            <?php  echo ISSET($_SESSION['close_accountConfirmed']) ? '' : 'disabled' 
            // Ternary statement here to check if the button should be disabled onload based on if 
            // account has been confirmed already 
            ?>/>
        </div>
     
    </form>
    </div>
    <!-- php section -->
    <?php
        // if the name is unset and the id is, after the query was made print the error message
        if (!ISSET($_SESSION['close_loanname']) and ISSET($_SESSION['close_AccountNumber'])) {
        
            echo '<p class="errorStyle">
            No record found for account number : ' . $_SESSION['close_AccountNumber'] . ' <br> 
            Please try again!
            </p>';
            // unset the customerID to clear the variable
            unset ($_SESSION['close_AccountNumber']); 
        }
    ?>
    </main>
</body>
</html>