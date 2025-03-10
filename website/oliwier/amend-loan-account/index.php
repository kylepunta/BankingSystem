<?php session_start(); // start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="amend.css">
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
            document.getElementById("submit").disabled = true;
            document.getElementById("toggle").disabled = true;

            if (result == "placeholder") {
                // if the placeholder is selected clear the fields
                document.getElementById("custID").value = "";
                document.getElementById("address").value = "";
                document.getElementById("eircode").value = "";
                document.getElementById("dob").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("closeAccountNumber").value = "";
                document.getElementById("balance").value = "";
                document.getElementById("loanAmount").value = "";
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
            document.getElementById("closeAccountNumber").value = personDetails[5];
            document.getElementById("balance").value = personDetails[6];
            document.getElementById("repayments").value = personDetails[7];
            document.getElementById("term").value = personDetails[8];
            document.getElementById("loanAmount").value = personDetails[9];

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
                return true;	// returns trues
            } else {	// the user cancelled the confirmation 
                return false;
	    	}
	    }

        function checkValid() {

           //#TODO //implement validation
           return true;
        }

        function unconfirmAccount() {
            document.getElementById("term").disabled = true;
            document.getElementById("loanAmount").disabled = true;
            document.getElementById("toggle").disabled = true;
            document.getElementById("submit").disabled = true;
        }

        function toggleForm() {
            
            var toggleButton = document.getElementById("toggle").value;
            if (toggleButton == "Amend Details") {
                document.getElementById("toggle").value = "View Details";
                document.getElementById("term").disabled = false;
                document.getElementById("loanAmount").disabled = false;
                document.getElementById("submit").disabled = false;
            }
            else {
                document.getElementById("toggle").value = "Amend Details";
                document.getElementById("term").disabled = true;
                document.getElementById("loanAmount").disabled = true;
                document.getElementById("submit").disabled = true;
            }
            
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
        
    </form>
    
    <div class="theForm">
        <h1>Amend/View Loan Account</h1>
    <form id="mainForm" action="amend.php" method="post" onsubmit="return confirmCheck()">
        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'name' -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onclick ="return populate()" value="<?php if (ISSET($_SESSION['name']) ) echo $_SESSION['name']?>">
                <?php include "listbox.php" ?>
            </select>
        </div>

        <!-- input for customer ID -->
        <div class="inputbox">
            <label for="custID">Enter the customer ID </label>
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off required form="checkCustomer" oninput="unconfirmAccount()"
            value="<?php if (ISSET($_SESSION['customerID']) ) echo $_SESSION['customerID']?>"/>    <!-- if the session var 'personid' is set echo that person id -->
        </div>

        <!-- box for account number that is generated -->
        <!-- the text changes depending on the value of the session var 'closeAccountNumber' -->
        <div class="inputbox">
            <label for="closeAccountNumber">Account Number</label>
            <input type="text" name="closeAccountNumber" id="closeAccountNumber" 
            placeholder="10000000" form="checkCustomer" required oninput="unconfirmAccount()"
            value="<?php if (ISSET($_SESSION['closeAccountNumber']) ) echo $_SESSION['closeAccountNumber']?>"/>
        </div>

        <div class="button" style="display: flex; justify-content: space-between;">
            <!-- submit button -->
            <input type="submit" value="Confirm customer" form="checkCustomer"/>
            <input type="button" id="toggle" value="Amend Details" onclick="toggleForm()" form="" 
            <?php  echo ISSET($_SESSION['accountConfirmed']) ? '' : 'disabled' ?>/>
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

        <!-- box for loan amount. -->
       <div class="inputbox">
        <label for="balance">Loan Balance </label>
            <input type="number" name="balance" id="balance" placeholder="balance" autocomplete=off required 
            form="mainForm" disabled
            value="<?php if (ISSET($_SESSION['balance']) ) echo $_SESSION['balance']?>"/> 
        </div>

         <!-- box for loan amount. -->
       <div class="inputbox">
        <label for="loanAmount">Loan amount </label>
            <input type="number" name="loanAmount" id="loanAmount" placeholder="loanAmount" autocomplete=off required 
            form="mainForm" class="myInputs" disabled
            value="<?php if (ISSET($_SESSION['amount']) ) echo $_SESSION['amount']?>"/> 
        </div>

    
        <!-- box for loan term. -->
       <div class="inputbox">
        <label for="term">Term of loan</label>
            <input type="number" name="term" id="term" placeholder="term" autocomplete=off required 
            form="mainForm" onclick="clearRepayments()" class="myInputs" disabled
            value="<?php if (ISSET($_SESSION['term']) ) echo $_SESSION['term']?>"/> 
        </div>

        <!-- box for calculated monthly repayments -->

        <div class="inputbox">
            <label for="repayments">Monthly repayments</label>
            <input type="text" name="repayments" id="repayments" onblur="" placeholder="repayments" disabled
            onclick="clearRepayments()" class="myInputs"
            value="<?php if (ISSET($_SESSION['repayments']) ) echo $_SESSION['repayments']?>"
            />
        </div>

        <!-- submit button -->
         <div class="button">
        <input type="submit" id="submit" value="Update Account" disabled />
    </div>
        <p>
    </form>

    </div>
    <!-- php section -->
    <?php
        // if firstname and personid are unset after the query was made print the error message
        if (!ISSET($_SESSION['name']) and ISSET($_SESSION['customerID'])) {
        
            echo '<p style="color: red; text-align: center; font-size:20">
            No record found for a customer with id :' . $_SESSION['customerID'] .' and account number : ' . $_SESSION['closeAccountNumber'] . ' <br> Please try again!
            </p>';
            // unset the personid to clear the variable
            unset ($_SESSION['customerID']); 
        }
    ?>
    </main>
</body>
</html>