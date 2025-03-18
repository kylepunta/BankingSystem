<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 10/03/2025
Withdrawals -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<!-- TODO allow entry by account number which populates the customer details -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Withdrawals</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="./withdrawals.css">
    <script src="./withdrawals.js"></script>
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
    include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';

    // TODO move into function
    // TODO add deposit accounts
    $sql = "SELECT `Customer`.customerNo, `Current Account`.accountId, accountNumber, balance, overdraftLimit, 'Current' AS 'Type' FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.accountId = `Customer/CurrentAccount`.accountId
INNER JOIN `Customer` ON `Customer/CurrentAccount`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Current Account`.deletedFlag = 0
UNION (SELECT `Customer`.customerNo, `Deposit Account`.accountId, accountNumber, balance, '0' AS 'overdraftLimit', 'Deposit' AS 'Type' FROM `Deposit Account`
INNER JOIN `Customer/Deposit Account` ON `Deposit Account`.accountId = `Customer/Deposit Account`.accountId
INNER JOIN `Customer` ON `Customer/Deposit Account`.`customerNo` = `Customer`.`customerNo`
WHERE `Customer`.deletedFlag = 0 AND `Deposit Account`.deletedFlag = 0)";

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
        <form action="withdrawals.php" onsubmit="return confirmSubmit()" method="post">
            <!-- the heading of the form -->
            <h2>Withdrawals</h2>
            <!-- smaller text under the main heading -->
            <h4>Please select a current or deposit account and then click the withdraw button if you wish to</h4>

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
                <label for="accounttype">Account type:</label>
                <!-- the accounttype input box -->
                <input type="text" name="accounttype" id="accounttype" placeholder="Account type" disabled>
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

            <!-- a div which groups the input box and it's label -->
            <div class="inputbox">
                <label for="withdrawalamt">Withdrawal amount:</label>
                <!-- the withdrawalamt input box -->
                <input type="number" name="withdrawalamt" id="withdrawalamt" oninput="inputAmount(this)" placeholder="Withdrawal amount" min="0" step="0.01" required>
            </div>

            <!-- a div which groups the buttons -->
            <div class="myButton">
                <!-- the submit button -->
                <input class="button" type="submit" value="Withdraw" name="submit">
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