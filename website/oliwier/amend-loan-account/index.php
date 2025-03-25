<!--
Name: Oliwier Jakubiec
Date: March 2025
ID : C00296807
Title: main page for amend loan account
	-->
<?php session_start(); // start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend Loan Account</title>
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
        <h1>Amend/View Loan Account</h1>
    <form id="mainForm" action="amend.php" method="post" onsubmit="return confirmCheck()">
        <!-- dropdown with customer name -->
        <!-- the text changes depending on the value of the session var 'amend_name' -->
        <!-- these three next inputs are for the "checkCustomer" form -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onchange ="return populate()" 
            value="<?php if (ISSET($_SESSION['amend_name']) ) echo $_SESSION['amend_name']?>">
                <?php include "listbox.php" ?>
            </select>
        </div>

        <!-- input for customer number -->
        <!-- on input make sure to unconfirm the account to prevent incorrect changes -->
        <div class="inputbox">
            <label for="custID">Customer Number </label>
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off form="checkCustomer" 
            oninput="unconfirmAccount()" title="Enter a customer number" min="0"
            value="<?php if (ISSET($_SESSION['amend_customerID']) ) echo $_SESSION['amend_customerID']?>"/>  
        </div>

        <!-- box for account number that is generated -->
        <!-- the text changes depending on the value of the session var 'closeAccountNumber' -->
        <!-- on input make sure to unconfirm the account to prevent incorrect changes -->
        <div class="inputbox">
            <label for="AccountNumber">Account Number</label>
            <input type="text" name="AccountNumber" id="AccountNumber" 
            placeholder="10000000" form="checkCustomer" required oninput="unconfirmAccount()"
            title="Enter the account number as an 8 digit long number" pattern="[\d]{8}"
            value="<?php if (ISSET($_SESSION['amend_AccountNumber']) ) echo $_SESSION['amend_AccountNumber']?>"/>
        </div>

        <!-- buttons to confirm the customer and toggle view  -->
        <div class="button" style="display: flex; justify-content: space-between;">
            <!-- submit button -->
            <input type="submit" value="Confirm customer" form="checkCustomer"/>
            <!-- toggle button -->  
            <!-- set the form as null to make it not submit to anything -->
            <input type="button" id="toggle" value="Amend Details" onclick="toggleForm()" form="" 
            <?php  echo ISSET($_SESSION['amend_accountConfirmed']) ? '' : 'disabled' 
                // ternary statement here to check if the button should be disabled onload based on if
                // account has been confirmed already 
            ?>/>
        </div>
        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'address' -->
        <div class="inputbox">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled 
            value="<?php if (ISSET($_SESSION['amend_address']) ) echo $_SESSION['amend_address']?>"/>
        </div>

        <!-- box for eircode -->
        <!-- the text changes depending on the value of the session var 'eircode' -->
        <div class="inputbox">
            <label for="eircode">Eircode</label>
            <input type="text" name="eircode" id="eircode" placeholder="eircode" disabled 
                value="<?php if (ISSET($_SESSION['amend_eircode']) ) echo $_SESSION['amend_eircode']?>" />
            </div>

        <!-- box for date of birth -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <div class="inputbox">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" disabled 
            value="<?php if (ISSET($_SESSION['amend_dob']) ) echo $_SESSION['amend_dob']?>"/>
        </div>

        <!-- box for customer phone no. -->
        <!-- the text changes depending on the value of the session var 'phone' -->
        <div class="inputbox">
            <label for="phone">Phone number</label>
            <input type="text" name="phone" id="phone" placeholder="phone" disabled
            value="<?php if (ISSET($_SESSION['amend_phone']) ) echo $_SESSION['amend_phone']?>"/>
        </div>

        <!-- box for loan balance. -->
        <!-- the text changes depending on the value of the session var 'balance' -->
       <div class="inputbox">
        <label for="balance">Loan Balance </label>
            <input type="number" name="balance" id="balance" placeholder="balance" autocomplete=off required 
            form="mainForm" disabled
            value="<?php if (ISSET($_SESSION['amend_balance']) ) echo $_SESSION['amend_balance']?>"/> 
        </div>

         <!-- box for loan amount. -->
        <!-- the text changes depending on the value of the session var 'loan amount' -->
       <div class="inputbox">
        <label for="loanAmount">Loan amount </label>
            <input type="number" name="loanAmount" id="loanAmount" placeholder="loanAmount" autocomplete=off required 
            form="mainForm"  disabled min="0"
            title="Enter the loan amount"
            value="<?php if (ISSET($_SESSION['amend_amount']) ) echo $_SESSION['amend_amount']?>"/> 
        </div>

    
        <!-- box for loan term. -->
        <!-- the text changes depending on the value of the session var 'term' -->
       <div class="inputbox">
        <label for="term">Term of loan</label>
            <input type="number" name="term" id="term" placeholder="term" autocomplete=off required 
            form="mainForm" onclick="clearRepayments()"  disabled min="0" step="1"
            title="Enter the term of the loan in months"
            value="<?php if (ISSET($_SESSION['amend_term']) ) echo $_SESSION['amend_term']?>"/> 
        </div>

        <!-- box for monthly repayments -->
        <!-- the text changes depending on the value of the session var 'repayments' -->
        <div class="inputbox">
            <label for="repayments">Monthly repayments</label>
            <input type="text" name="repayments" id="repayments" onblur="" placeholder="repayments" disabled
            onclick="clearRepayments()" 
            value="<?php if (ISSET($_SESSION['amend_repayments']) ) echo $_SESSION['amend_repayments']?>"
            />
        </div>

        <!-- submit button -->
         <div class="button">
            <input type="submit" id="submit" value="Update Account" disabled />
        </div>
    </form>

    </div>
    <!-- php section -->
    <?php
        // if the name is unset and the id is, after the query was made print the error message
        if (!ISSET($_SESSION['amend_name']) and ISSET($_SESSION['amend_AccountNumber'])) {
    
            echo '<p class="errorStyle">
            No record found for account number : ' . $_SESSION['amend_AccountNumber'] . ' <br> 
            Please try again!
            </p>';
            // unset the customerID to clear the variable
            unset ($_SESSION['amend_AccountNumber']); 
        }
    ?>
    </main>
</body>
</html>