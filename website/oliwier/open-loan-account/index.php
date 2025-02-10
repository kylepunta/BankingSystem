<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<!-- •	customer name
    •	address
    •	eircode
    •	date of birth
    •	customer number
 -->
<body>
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>
    <main>
        
        <!-- create form with action displayview1 and method post -->
    <form action="displayview1.php" method="post">
        <h1>Search Customer</h1>
        <!-- input for customer ID -->
        <p><label for="custID">Enter the customer ID you want to find</label>
            <input type="text" name="custID" id="custID" placeholder="custID" autocomplete=off required
                value="<?php if (ISSET($_SESSION['customerID']) ) echo $_SESSION['customerID']?>" />    <!-- if the session var 'personid' is set echo that person id -->
        </p>

        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'firstname' -->
        <p><label for="custName">Customer name </label>
            <input type="text" name="custName" id="custName" placeholder="Name" disabled
                value="<?php if (ISSET($_SESSION['firstname']) ) echo $_SESSION['firstname']?>" />
        </p>

        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'lastname' -->
        <p><label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled
                value="<?php if (ISSET($_SESSION['address']) ) echo $_SESSION['address']?>" />
        </p>

        <!-- box for Last name -->
        <!-- the text changes depending on the value of the session var 'lastname' -->
        <p><label for="eircode">Eircode</label>
            <input type="text" name="eircode" id="eircode" placeholder="eircode" disabled
                value="<?php if (ISSET($_SESSION['eircode']) ) echo $_SESSION['eircode']?>" />
        </p>

        <!-- box for date of birth -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <p><label for="dob">Date Of Birth</label>
            <input type="text" name="dob" id="dob" placeholder="Date of Birth" disabled
                value="<?php if (ISSET($_SESSION['dob']) ) echo $_SESSION['dob']?>" />
        </p>

        <!-- box for customer phone no. -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <p><label for="phone">Phone number</label>
            <input type="text" name="phone" id="phone" placeholder="phone" disabled
                value="<?php if (ISSET($_SESSION['phone']) ) echo $_SESSION['phone']?>" />
        </p>

        <!-- box for loan amount. -->
       <p><label for="loanAmount">Enter the loan amount </label>
            <input type="text" name="loanAmount" id="loanAmount" placeholder="loanAmount" autocomplete=off required
                value="<?php if (ISSET($_SESSION['loanAmount']) ) echo $_SESSION['loanAmount']?>" /> 
        </p>

        <!-- box for loan term. -->
       <p><label for="term">Enter the term of the loan</label>
            <input type="text" name="term" id="term" placeholder="term" autocomplete=off required
                value="<?php if (ISSET($_SESSION['term']) ) echo $_SESSION['term']?>" /> 
        </p>

        <!-- box for calculated monthly repayments -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <p><label for="repayments">Monthly repayments</label>
            <input type="text" name="repayments" id="repayments" placeholder="repayments" disabled
                value="<?php if (ISSET($_SESSION['repayments']) ) echo $_SESSION['repayments']?>" />
        </p>

        <br> <br>
        <!-- submit button -->
        <input type="submit" value="Submit" />
        <p>
    </form>
    <!-- php section -->
    <?php
        // if firstname and personid are unset after the query was made print the error message
        if (!ISSET($_SESSION['firstname']) and ISSET($_SESSION['personid'])) {
        
            echo '<p style="color: red; text-align: center; font-size:20">
            No record found for a person with id..' . $_SESSION['personid'] . ' <br> Please try again!
            </p>';
            // unset the personid to clear the variable
            unset ($_SESSION['personid']); 
        }
    ?>
    </main>
</body>
</html>