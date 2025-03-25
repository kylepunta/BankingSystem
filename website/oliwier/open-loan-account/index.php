<!--
Name: Oliwier Jakubiec
Date: Feb 2025
ID : C00296807
Title: main page for open loan account
	-->
<?php session_start(); // start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Loan Account</title>
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
        
    <div class="theForm">
    <!-- create form with action displayview and method post
         this empty form is used for confirming the customer, the fields for it 
         are later in the form for clarity -->
    <form id="checkCustomer" action="displayView.php" method="post"></form>

    <!-- main form with action insert.php-->
    <form id="mainForm" action="insert.php" method="post" onsubmit="return confirmCheck()">

        <h1>Open Loan Account</h1>

        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'name' -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onchange ="return populate()"
            value="<?php if (ISSET($_SESSION['name']) ) echo $_SESSION['name']?>"> 
                <?php include "listbox.php" ?>
            </select>
        </div>

        <!-- input for customer ID -->
        <!-- the text changes depending on the value of the session var 'customer ID' -->
        <div class="inputbox">
            <label for="custID">Customer Number </label> 
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off required form="checkCustomer" min="0"
            title="Enter a customer number"
            value="<?php if (ISSET($_SESSION['customerID']) ) echo $_SESSION['customerID']?>"/>   
        </div>
        
        <!-- button to submit customer ID -->
        <div class="button">
            <!-- submit button -->
            <input type="submit" value="Confirm customer" form="checkCustomer"/>
        </div>

        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'address' -->
        <div class="inputbox">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled 
            value="<?php if (ISSET($_SESSION['address']) ) echo $_SESSION['address']?>"/>
        </div>

        <!-- box for Last name -->
        <!-- the text changes depending on the value of the session var 'eircode' -->
        <div class="inputbox">
            <label for="eircode">Eircode</label>
            <input type="text" name="eircode" id="eircode" placeholder="eircode" disabled 
                value="<?php if (ISSET($_SESSION['eircode']) ) echo $_SESSION['eircode']?>" />
            </div>

        <!-- box for date of birth -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <div class="inputbox">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" disabled 
            value="<?php if (ISSET($_SESSION['dob']) ) echo $_SESSION['dob']?>"/>
        </div>

        <!-- box for customer phone no. -->
        <!-- the text changes depending on the value of the session var 'phone' -->
        <div class="inputbox">
            <label for="phone">Phone number</label>
            <input type="text" name="phone" id="phone" placeholder="phone" disabled 
            value="<?php if (ISSET($_SESSION['phone']) ) echo $_SESSION['phone']?>"/>
        </div>

        <!-- box for account number that is generated -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <div class="inputbox">
            <label for="accountNumber">Account Number</label>
            <input type="text" name="accountNumber" id="accountNumber" disabled 
            value="<?php if (ISSET($_SESSION['loanaccountNumber']) ) echo $_SESSION['loanaccountNumber']?>"/>
        </div>

        <!-- box for loan amount. -->
        <!-- the text changes depending on the value of the session var 'amount' -->
       <div class="inputbox">
        <label for="loanAmount">Enter the loan amount </label>
            <input type="number" name="loanAmount" id="loanAmount" placeholder="loanAmount" autocomplete=off 
            required form="calcpay" step="0.01" min="0" onclick="clearRepayments()"
            title = "Enter the loan amount as a positive number"
            value="<?php if (ISSET($_SESSION['amount']) ) echo $_SESSION['amount']?>"/> 
        </div>

        <!-- box for loan term. -->
        <!-- the text changes depending on the value of the session var 'term' -->
       <div class="inputbox">
        <label for="term">Enter the term of the loan</label>
            <input type="number" name="term" id="term" placeholder="term" autocomplete=off required form="calcpay"
             onclick="clearRepayments()"  min="1" title="Enter the term of the loan in months"
            value="<?php if (ISSET($_SESSION['term']) ) echo $_SESSION['term']?>"/> 
        </div>

        <!-- box for calculated monthly repayments -->
        <!-- the text changes depending on the value of the session var 'repayamount' -->
        <div class="inputbox">
            <label for="repayments">Monthly repayments</label>
            <input type="text" name="repayments" id="repayments" onblur="" placeholder="repayments" disabled 
            title="Press 'calculate repayments' to fill this field"
            value="<?php if (ISSET($_SESSION['repayAmount']) ) echo $_SESSION['repayAmount']?>"
            />
        </div>

        <!-- div to align both buttons -->
        <div class="button" style="display: flex; justify-content: space-between;">
            <!-- calculate repayments button -->
             <div class="button">
                <input type="submit" value="Calculate Repayments" form="calcpay" />
            </div>
            <!-- submit button -->
             <div class="button">
                <input type="submit" value="Open Loan Account" />
            </div>
        </div>
        
    </form>
    
    <form id="calcpay" action="calcRate.php" method="post" onsubmit="return checkValidRepay()"></form>
    
    </div>
    <!-- php section -->
    <?php
        // if the name is unset and the id is, after the query was made print the error message
        if (!ISSET($_SESSION['name']) and ISSET($_SESSION['customerID'])) {
        
            echo '<p class="errorStyle">
            No record found for a customer with id : ' . $_SESSION['customerID'] . ' <br> Please try again!
            </p>';
            // unset the customerID to clear the variable
            unset ($_SESSION['customerID']); 
        }
    ?>
    </main>
</body>
</html>