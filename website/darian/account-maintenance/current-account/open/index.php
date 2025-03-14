<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Open Current Account</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="./open.css">
    <script src="./open.js"></script>
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
    require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php');
    $_SESSION["accountno"] = generateAccountNo(); ?>
    <script>
        // this code is a bit weird, I found it to be the best way to send server side php data to the client side javascript
        // it generates a unique account number when the page loads
        // it then stores the account number in a global variable
        // this global variable is then referenced when the user selects a customer
        var accountno = '<?php echo $_SESSION["accountno"]; ?>';
    </script>
    <main>
        <form action="open.php" onsubmit="return confirmSubmit()" method="post">
            <!-- the heading of the form -->
            <h2>Open Current Account</h2>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="cid">Customer number:</label>
                <!-- the cid input box -->
                <input type="number" name="cid" id="cid" placeholder="Customer number" onchange="inputCustomer(this)" min="0" step="1" required>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="name">Customer Name:</label>
                <!-- the name select box -->
                <select id="name" onchange="populate(this)" required>
                    <option></option>
                    <?php require('./listbox.php'); ?>
                </select>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="address">Address:</label>
                <!-- the address input box -->
                <input type="text" name="address" id="address" placeholder="Address" disabled>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <!-- the eircode input box -->
                <input type="text" name="eircode" id="eircode" placeholder="Eircode" disabled>
            </div>

            <!-- a div which groups the calendar and it's label -->
            <div class="inputbox">
                <label for="dob">Date of Birth:</label>
                <!-- the dob calendar -->
                <input type="date" name="dob" id="dob" disabled>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="accountno">Account number:</label>
                <!-- the accountno input box -->
                <input type="text" name="accountno" id="accountno" placeholder="Account number" disabled>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="overdraftlimit">Overdraft limit:</label>
                <!-- the overdraftlimit input box -->
                <input type="number" name="overdraftlimit" id="overdraftlimit" placeholder="Overdraft limit" title="0 for no limit" min="0" step="0.01" required>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="initbal">Initial Deposit:</label>
                <!-- the initbal input box -->
                <input type="number" name="initbal" id="initbal" value="0" placeholder="Initial Deposit" title="0 for no first deposit" min="0" step="0.01" required>
            </div>

            <!-- a div which groups the buttons -->
            <div class="myButton">
                <!-- the submit button -->
                <input class="button" type="submit" value="Open current account" name="submit">
                <!-- the reset button -->
                <input class="button" type="reset" value="Cancel" name="reset">
            </div>

            <!-- paragraph that will be used to display a message to the user after submitting the form -->
            <p class="display">
                <?php
                // checks if there is a message and displays it
                if (isset($_SESSION["message"])) echo $_SESSION["message"];
                // clears the message afterward
                unset($_SESSION["message"]); ?></p>
        </form>
    </main>
</body>

</html>