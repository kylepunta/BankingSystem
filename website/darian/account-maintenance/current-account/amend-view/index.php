<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account -->
<?php session_start();
if (!isset($_SESSION["errorMsg"])) $_SESSION["errorMsg"] = "";
global $validId;
global $validAccount;
?>
<!DOCTYPE html>
<html lang="en">
<!-- TODO allow entry by account number which populates the customer details -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Amend/View Current Account</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="/darian/darianStyles.css">
    <script src="/darian/darianScript.js"></script>
    <script src="amend-view.js"></script>
</head>

<body>
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
//TODO move into .inc.php
function clearPreviousAccount()
{
    unset($_POST["accountno"]);
    unset($_SESSION["balance"]);
    unset($_SESSION["overdraftLimit"]);
}

function clearPreviousCustomer()
{
    unset($_SESSION["address"]);
    unset($_SESSION["eircode"]);
    unset($_SESSION["dob"]);
}

$gotAccountNo = !empty($_POST["accountno"]);
$gotCustomerId = !empty($_POST["cid"]);

// now check if the account is to be amended
if (!empty($_POST["confirmed"]) && $gotCustomerId && $gotAccountNo) {
    require("amend-view.php");
} else if ($gotAccountNo && $gotCustomerId) {
    // user entered both account number and customerId
    require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
    global $con;

    // selects the account, makes sure that the customerId entered belongs to the account number entered
    $sql = "SELECT `accountNumber`, `customerNo` FROM `Current Account`
INNER JOIN `Customer/CurrentAccount` ON `Current Account`.`accountId` = `Customer/CurrentAccount`.`accountId`
WHERE `accountNumber` = '$_POST[accountno]' AND `customerNo` = '$_POST[cid]'";
    // checks that the sql query was successful
    if (!$result = mysqli_query($con, $sql)) {
        // displays the error that caused the query to fail
        // exits the script
        die("An error in the SQL Query: " . mysqli_error($con));
    }
    // closes the connection
    mysqli_close($con);

    // checks that a valid account was selected
    if (mysqli_num_rows($result) != 0) {
        // displays both customer details and account details
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/currentAccountDetails.inc.php');
    } else {
        // if the account number and customer mismatch, just display the customers details and reset the account details
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
        clearPreviousAccount();
    }
} else if ($gotAccountNo) {
    // only an account number was entered, display that account
    require($_SERVER["DOCUMENT_ROOT"] . '/darian/currentAccountDetails.inc.php');
    // then if the account entered was valid
    if ($validAccount) {
        // display the customer for that account
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
    } else {
        // otherwise clear the selected customer
        clearPreviousCustomer();
    }
} else if ($gotCustomerId) {
    // only a customerId was entered, display that customer
    require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
    // clear the account details from before
    clearPreviousAccount();
} else {
    // the form is empty, clear any details
    clearPreviousCustomer();
    clearPreviousAccount();
}

// // TODO sql for transaction history
// $sql = "SELECT accountNumber, date, transactionType, amount, `Current Account History`.balance
// FROM `Current Account History`
// INNER JOIN `Current Account` ON `Current Account History`.accountId = `Current Account`.accountId
// ORDER BY `Current Account History`.accountId, date DESC, transactionId DESC";
?>
<main>
    <form action="./" onsubmit="return confirmSubmit()" method="post">
        <!-- the heading of the form -->
        <h2>Amend/View Current Account</h2>
        <!-- smaller text under the main heading -->
        <h4>Please select a current account and then click the amend button if you wish to update</h4>

        <!-- toggle button for viewing/amending account details -->
        <input class="button" type="button" value="Amend Details" id="amendViewbutton" onclick="toggleLock()">

        <!-- contains the labels and inputs for a customer -->
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.html.php') ?>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountno">Account number:</label>
            <!-- the accountno input box -->
            <input type="number" name="accountno" id="accountno" list="accounts"
                   value="<?php if (isset($_POST["accountno"])) echo $_POST["accountno"]; ?>"
                   placeholder="Account number" onchange="inputAccount(this)" min="0" step="1" required>
            <!-- this datalist is used to help prompt the user with a list of accounts that the customer has -->
            <datalist id="accounts">
                <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/currentAccountList.php'); ?>
            </datalist>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountbal">Account balance:</label>
            <!-- the accountbal input box -->
            <input type="text" name="accountbal" id="accountbal" value="<?php if (isset($_SESSION["balance"])) {
                require($_SERVER["DOCUMENT_ROOT"] . '/darian/balance.inc.php');
                echo displayBalance($_SESSION["balance"]);
            } ?>" placeholder="Account balance" disabled>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="overdraftlimit">Overdraft limit:</label>
            <!-- the overdraftlimit input box -->
            <input type="number" name="overdraftlimit" id="overdraftlimit"
                   value="<?php if (isset($_SESSION["overdraftLimit"])) echo $_SESSION["overdraftLimit"]; ?>"
                   placeholder="Overdraft limit" title="0 for no overdraft" min="0" step="0.01" required disabled>
        </div>

        <!-- a div which groups the buttons -->
        <div class="myButton">
            <!-- the submit button -->
            <input class="button" type="submit" value="Save current account details">
            <!-- the reset button -->
            <!-- TODO needs to work with amend/view state -->
            <input class="button" type="reset" value="Cancel" onclick="cancel()">
        </div>

        <!-- hidden input that is used to tell the server that the user has confirmed closing the current account -->
        <input type="hidden" name="confirmed" id="confirmed" value="0">

        <!-- paragraph that will be used to display a message to the user after submitting the form -->
        <p class="display">
            <?php
            // checks if there is a message and displays it
            // there's a text button that lets the user hide the message
            if (isset($_SESSION["message"])) echo "<span onclick='hide(this)'>Click here to hide:</span> " . $_SESSION["message"];
            // clears the message afterward
            unset($_SESSION["message"]); ?></p>
    </form>

    <!-- paragraph that will be used to display an error to the user after submitting the form -->
    <p class="errorDisplay">
        <?php
        // checks if there is an error and displays it
        if (isset($_SESSION["errorMsg"])) echo $_SESSION["errorMsg"];
        // clears the error afterward
        unset($_SESSION["errorMsg"]); ?></p>

    <!-- the heading of the table -->
    <h2>Last 10 transactions</h2>
    <!-- table of last 10 transactions -->
    <table id="transactions">
        <?php /* TODO require code for querying the transaction if an account is selected */

        include $_SERVER["DOCUMENT_ROOT"] . '/db.inc.php';

        $sql = "SELECT date, transactionType, amount, `Current Account History`.balance
FROM `Current Account History`
INNER JOIN `Current Account` ON `Current Account History`.accountId = `Current Account`.accountId
WHERE deletedFlag = 0 AND accountNumber =" . (!empty($_POST["accountno"]) ? "$_POST[accountno]" : "0") . "
ORDER BY `Current Account History`.accountId, date DESC, transactionId DESC";

        // checks that the sql query was successful
        if (!$result = mysqli_query($con, $sql)) {
            // displays the error that caused the query to fail
            // exits the script
            die("An error in the SQL Query: " . mysqli_error($con));
        }

        // string that will be used to store the transactions
        echo "<tr><th>Date</th><th>Type</th><th>Amount</th><th>Balance</th></tr>";

        $i = 0;
        while ($i < 10 && $row = mysqli_fetch_array($result)) {
            // TODO is this how catherine did it?
            $date = $row["date"];
            $type = $row["transactionType"];
            $amount = $row["amount"];
            $balance = $row["balance"];
            echo "<tr><td>$date</td><td>$type</td><td>$amount</td><td>$balance</td></tr>";
            $i++;
        }

        mysqli_close($con); ?>
    </table>
</main>
</body>

</html>