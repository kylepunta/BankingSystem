<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<!-- TODO allow entry by account number which populates the customer details -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Amend/View Current Account</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="./amend-view.css">
    <script src="./amend-view.js"></script>
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
    include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';

    // TODO consider deleted customers AND deleted accounts
    // TODO move into function
    $sql = "SELECT customerNo, `Current Account`.accountId, accountNumber, balance, overdraftLimit FROM `Current Account`
    INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
    WHERE deletedFlag = 0";

    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query1: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {
        $accounts[] = $row;
    }

    $_SESSION["accounts"] = $accounts;

    // TODO move into function
    $sql = "SELECT accountNumber, date, transactionType, amount, `Current Account History`.balance
    FROM `Current Account History`
    INNER JOIN `Current Account` ON `Current Account History`.accountId = `Current Account`.accountId
    ORDER BY `Current Account History`.accountId, date DESC, transactionId DESC";

    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query1: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {
        $transactions[] = $row;
    }

    $_SESSION["transactions"] = $transactions;
    ?>

    <script>
        // this code is a bit weird, I found it to be the best way to send server side php data to the client side javascript
        // it encodes the PHP array into a JSON format,
        // then the JS parses the JSON format into a JS array
        // the JS array is then stored in a global variable
        // this global variable is then referenced when the user selects a customer
        let php = '<?php echo json_encode($_SESSION["accounts"]); ?>';
        var accounts = JSON.parse(php);
        php = '<?php echo json_encode($_SESSION["transactions"]); ?>';
        var transactions = JSON.parse(php);
    </script>
    <main>
        <form action="amend-view.php" onsubmit="return confirmSubmit()" method="post">
            <!-- the heading of the form -->
            <h2>Amend/View Current Account</h2>
            <!-- smaller text under the main heading -->
            <h4>Please select a current account and then click the amend button if you wish to update</h4>

            <!-- toggle button for viewing/amending student details -->
            <input class="button" type="button" value="Amend Details" id="amendViewbutton" onclick="toggleLock()">

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
                <input type="number" name="accountno" id="accountno" list="accounts" onchange="inputAccount(this)" placeholder="Account number">
                <!-- this datalist is used to help prompt the user with a list of accounts that the customer has -->
                <datalist id="accounts"><!-- filled by JS function --></datalist>
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
                <input type="text" name="overdraftlimit" id="overdraftlimit" onchange="inputOverdraftLimit(this)" placeholder="Overdraft limit" disabled>
            </div>

            <!-- a div which groups the buttons -->
            <div class="myButton">
                <!-- the submit button -->
                <input class="button" type="submit" value="Save current account details" name="submit">
            </div>

            <!-- paragraph that will be used to display a message to the user after submitting the form -->
            <p class="display">
                <?php
                // checks if there is a message and displays it
                if (isset($_SESSION["message"])) echo $_SESSION["message"];
                // clears the message afterward
                unset($_SESSION["message"]); ?></p>
        </form>

        <!-- the heading of the table -->
        <h2>Last 10 transactions</h2>
        <!-- table of last 10 transactions -->
        <table id="transactions">
        </table>
    </main>
</body>

</html>