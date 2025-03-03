<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./close.css">
    <script src="./close.js"></script>
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
    require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php');
    include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';

    // TODO move into function
    // TODO maybe needs customerId too
    $sql = "SELECT accountId, accountNumber, balance, overdraftLimit FROM `Current Account` WHERE deletedFlag = 0";

    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query1: " . mysqli_error($con));
    }

    while($row = mysqli_fetch_array($result)) {
        $accounts[] = $row;
    }

    $_SESSION["accounts"] = $accounts;
     ?>

    <script>
        // this code is a bit weird, I found it to be the best way to send server side php data to the client side javascript
        // it encodes the PHP array into a JSON format,
        // then the JS parses the JSON format into a JS array
        // the JS array is then stored in a global variable
        // this global variable is then referenced when the user selects a customer
        let php = '<?php echo json_encode($_SESSION["accounts"]); ?>';
        var accounts = JSON.parse(php);
    </script>
    <main>
        <form action="close.php" onsubmit="return confirmSubmit()" method="post">
            <!-- the heading of the form -->
            <h2>Close Current Account</h2>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="cid">Customer number:</label>
                <!-- the cid input box -->
                <input type="number" name="cid" id="cid" placeholder="Customer number" onchange="inputCustomerCid(this)" value="<?php if (isset($_SESSION["cid"])) echo $_SESSION["cid"] ?>" min="0" step="1" required>
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
                 <!-- TODO worry about validating account number belongs to selected customer -->
                <input type="number" name="accountno" id="accountno" onchange="inputAccount(this)" placeholder="Account number">
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="accountbal">Account balance:</label>
                <!-- the accountbal input box -->
                <input type="text" name="accountbal" id="accountbal" placeholder="Account balance" disabled>
            </div>

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="overdraftlimit">Overdraft limit:</label>
                <!-- the overdraftlimit input box -->
                <input type="text" name="overdraftlimit" id="overdraftlimit" placeholder="Overdraft limit" disabled>
            </div>

            <!-- a div which groups the buttons -->
            <div class="myButton">
                <!-- the submit button -->
                <input class="button" type="submit" value="Close current account" name="submit">
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