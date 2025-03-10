<?php session_start(); // start the session
?>
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

<body>
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>

    <script>

        // function to display a student details based on the value in listbox
        function populate() {
            // get the listbox element
            var sel = document.getElementById("listbox");
            // get the selected item in the dropdown
            var result = sel.options[sel.selectedIndex].value;

            if (result == "placeholder") {
                // if the placeholder is selected clear the fields
                document.getElementById("custID").value = "";
                document.getElementById("address").value = "";
                document.getElementById("eircode").value = "";
                document.getElementById("dob").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("accountNumber").value = "";
                document.getElementById("loanAmount").disabled = true;
                document.getElementById("loanAmount").value= "";
                document.getElementById("term").disabled = true;
                document.getElementById("term").value = "";
                document.getElementById("repayments").value = "";
                return;
            }
            // make an array of the student details by splitting the result by the delimitter ','
            var personDetails = result.split('#');
            // display the details in the <p> tag
            console.log(personDetails);
            // get elements and display the results in the array
        
            document.getElementById("custID").value = personDetails[0];
            document.getElementById("address").value = personDetails[1];
            document.getElementById("eircode").value = personDetails[2];
            document.getElementById("dob").value = personDetails[3];
            document.getElementById("phone").value = personDetails[4];

            document.getElementById("loanAmount").disabled = false;
            document.getElementById("term").disabled = false;
        }

        // function to check if the user wants to really submit the updated form 
	    function confirmCheck() {
            // chek if the form is valid first
            if (!checkValid()) {return false;}
		    
            // declare variable
            var response;
            // confirm returns true if the Ok option is selected
            response = confirm('Are you sure you want to save these changes?');
            if (response) { // check for "ok"
                // enable the textboxes as disabled boxes cannot send their data
                document.getElementById("repayments").disabled = false;
                return true;	// returns trues
            } else {	// the user cancelled the confirmation 
               // populate();		// repopulate the fields to reset them
                return false;
	    	}
	    }

        function checkValid() {

            var loanAmount = document.getElementById("loanAmount");
            var term = document.getElementById("term");
            var payments = document.getElementById("repayments");
            var accountNo = document.getElementById("accountNumber");
            // get the listbox element
            var sel = document.getElementById("listbox");
            // get the selected item in the dropdown
            var result = sel.options[sel.selectedIndex].value;

            console.log(result )
            if (result == "placeholder") {
            //    id.setCustomValidity("Please select a customer");
                alert("Please select a customer");
                return false;
            }
            if (loanAmount.value == "" || loanAmount.value < 0) {
                alert("Please enter the loan amount as a positive number");
                return false;
            }

            if (term.value== "" || loanAmount.value < 0) {
                alert("Please enter the term length as a positive number");
                return false;
            }

            if (payments.value == "") {
                alert("Please calculate the repayment amounts");
                return false;
            }
            if (accountNo.value == "") {
                alert("Please confirm the customer to generate the account number");
                return false;
            }

            
            return true;
        }

        function clearRepayments() {
            var payments = document.getElementById("repayments").value;
            console.log(payments);
            payments = "";
            console.log(payments);
            document.getElementById("repayments").disabled = false;
            document.getElementById("repayments").value = "";
            document.getElementById("repayments").disabled = true;
        }

    </script>
    <main>
        
        <!-- create form with action displayview1 and method post -->
    <form id="checkCustomer" action="displayView.php" method="post">

        <!-- •	customer name
             •	address
             •	eircode 
             •	date of birth
             •	customer number
        -->
        <h1>Close Loan Account</h1>
        <!-- input for customer ID -->
        <div class="inputbox">
            <label for="custID">Enter the customer ID </label>
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off required 
            value="<?php if (ISSET($_SESSION['customerID']) ) echo $_SESSION['customerID']?>"/>    <!-- if the session var 'personid' is set echo that person id -->
        </div>

       

    </form>

    <form id="mainForm" action="insert.php" method="post" onsubmit="return confirmCheck()">
        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'firstname' -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onclick ="return populate()" 
            value="<?php if (ISSET($_SESSION['name']) ) echo $_SESSION['name']?>">
                <?php include "listbox.php" ?>
            </select>
        </div>
        <div class="buttons">
            <!-- submit button -->
            <input type="submit" value="Confirm customer" form="checkCustomer"/>
        </div>
        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'lastname' -->
        <div class="inputbox">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled 
            value="<?php if (ISSET($_SESSION['address']) ) echo $_SESSION['address']?>"/>
        </div>

        <!-- box for Last name -->
        <!-- the text changes depending on the value of the session var 'lastname' -->
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
        <!-- the text changes depending on the value of the session var 'dob' -->
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
            value="<?php if (ISSET($_SESSION['accountNumber']) ) echo $_SESSION['accountNumber']?>"/>
        </div>

        <!-- box for loan amount. -->
       <div class="inputbox">
        <label for="loanAmount">Enter the loan amount </label>
            <input type="number" name="loanAmount" id="loanAmount" placeholder="loanAmount" autocomplete=off required form="calcpay"
            form="mainForm" 
            value="<?php if (ISSET($_SESSION['amount']) ) echo $_SESSION['amount']?>"/> 
        </div>

    
    
        <!-- box for loan term. -->
       <div class="inputbox">
        <label for="term">Enter the term of the loan</label>
            <input type="number" name="term" id="term" placeholder="term" autocomplete=off required form="calcpay"
            form="mainForm" onclick="clearRepayments()"
            value="<?php if (ISSET($_SESSION['term']) ) echo $_SESSION['term']?>"/> 
        </div>

        <!-- box for calculated monthly repayments -->

        <div class="inputbox">
            <label for="repayments">Monthly repayments</label>
            <input type="text" name="repayments" id="repayments" onblur="" placeholder="repayments" disabled
            onclick="clearRepayments()"
            value="<?php if (ISSET($_SESSION['repayAmount']) ) echo $_SESSION['repayAmount']?>"
            />
        </div>
        <!-- submit button -->
         <div class="buttons">
        <input type="submit" value="Calculate Repayments" form="calcpay" />
        </div>
        <br> <br>
        <!-- submit button -->
         <div class="buttons">
        <input type="submit" value="Open Loan Account" />
    </div>
        <p>
    </form>
    <form id="calcpay" action="calcRate.php" method="post">
    <!-- php section -->
    <?php
        // if firstname and personid are unset after the query was made print the error message
        if (!ISSET($_SESSION['name']) and ISSET($_SESSION['customerID'])) {
        
            echo '<p style="color: red; text-align: center; font-size:20">
            No record found for a customer with id..' . $_SESSION['customerID'] . ' <br> Please try again!
            </p>';
            // unset the personid to clear the variable
            unset ($_SESSION['customerID']); 
        }
    ?>
    </main>
</body>
</html>