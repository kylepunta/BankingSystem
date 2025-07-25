<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account -->
<?php
// start a session
session_start();
// initialises the error message so it can be concatenated to
if (!isset($_SESSION["errorMsg"])) $_SESSION["errorMsg"] = "";
// declares that these variables are from another file and globally available
global $validId;
global $validAccount;
?>
<!DOCTYPE html>
<html lang="en">

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
<?php
// adds the side menu to the page
require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');

// function that clears any account values, stopping them from being displayed on the form
function clearPreviousAccount()
{
    // clear the values so they aren't displayed on the form
    unset($_POST["accountno"]);
    unset($_SESSION["balance"]);
    unset($_SESSION["overdraftLimit"]);
}

// function that clears any customer values, stopping them from being displayed on the form
function clearPreviousCustomer()
{
    // clear the values so they aren't displayed on the form
    unset($_SESSION["address"]);
    unset($_SESSION["eircode"]);
    unset($_SESSION["dob"]);
}

// stores if we 'got' a value (if it was entered by the user)
$gotAccountNo = !empty($_POST["accountno"]);
$gotCustomerId = !empty($_POST["cid"]);

// checks if the account is to be amended
// checks that the user confirmed and a customerId and account number were entered
if (!empty($_POST["confirmed"]) && $gotCustomerId && $gotAccountNo) {
    // continue to amend current account
    require("amend-view.php");
} else if ($gotAccountNo && $gotCustomerId) {
    // user entered both account number and customerId, but didn't confirm so just display those details
    // we're doing database operations, require that file
    require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
    // declares that these variables are from another file and globally available
    global $con;

    // stores the SQL statement to be queried later
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
?>
<main>
    <form action="./" onsubmit="return confirmSubmit()" method="post">
        <!-- the heading of the form -->
        <h2>Amend/View Current Account</h2>
        <!-- smaller text under the main heading -->
        <h4>Please select a current account and then click the amend button if you wish to update</h4>

        <!-- a div which centres the amend button -->
        <div class="myButton">
            <!-- toggle button for viewing/amending account details -->
            <input class="button" type="button" value="Amend Details" id="amendViewbutton" onclick="toggleLock()">
        </div>

        <!-- contains the labels and inputs for a customer -->
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.html.php') ?>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountno">Account number:</label>
            <!-- the accountno input box -->
            <input type="number" name="accountno" id="accountno" list="accounts" placeholder="Account number"
                   title="An account number is 8 digits, in the range 10000000 - 99999999"
                   value="<?php if (isset($_POST["accountno"])) echo $_POST["accountno"]; ?>"
                   onchange="inputAccount(this)" min="10000000" max="99999999" step="1" required>
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
        <!-- queries the transactions for the current account -->
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/currentAccountTransactions.php'); ?>
    </table>
</main>
</body>

</html>