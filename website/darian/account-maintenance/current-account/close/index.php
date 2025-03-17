<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account -->
<?php session_start();
if (!isset($_SESSION["errorMsg"])) $_SESSION["errorMsg"] = "";
global $validId;
global $validAccount;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Close Current Account</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="/darian/darianStyles.css">
    <script src="close.js"></script>
</head>

<body>
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
// TODO only accept current account details, currently accepts deposit and current accounts

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

// now check if the account is to be closed
if (!empty($_POST["confirmed"]) && $gotCustomerId && $gotAccountNo) {
    require("close.php");
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
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
    } else {
        // if the account number and customer mismatch, just display the customers details and reset the account details
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
        clearPreviousAccount();
    }
} else if ($gotAccountNo) {
    // only an account number was entered, display that account
    require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
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
        <h2>Close Current Account</h2>

        <!-- contains the labels and inputs for a customer -->
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.html.php') ?>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountno">Account number:</label>
            <!-- the accountno input box -->
            <!-- TODO only display current accounts, currently displays deposit and current accounts -->
            <!-- TODO allow getting the customer details just from entering the account number -->
            <input type="number" name="accountno" id="accountno" list="accounts"
                   value="<?php if (isset($_POST["accountno"])) echo $_POST["accountno"]; ?>"
                   placeholder="Account number" onchange="inputAccount(this)" min="0" step="1" required>
            <!-- this datalist is used to help prompt the user with a list of accounts that the customer has -->
            <datalist id="accounts">
                <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountList.php'); ?>
            </datalist>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountbal">Account balance:</label>
            <!-- the accountbal input box -->
            <!-- TODO echo with debit 100/credit 100 NOT 100/-100 -->
            <input type="text" name="accountbal" id="accountbal"
                   value="<?php if (isset($_SESSION["balance"])) echo $_SESSION["balance"]; ?>"
                   placeholder="Account balance" disabled>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="overdraftlimit">Overdraft limit:</label>
            <!-- the overdraftlimit input box -->
            <input type="text" name="overdraftlimit" id="overdraftlimit"
                   value="<?php if (isset($_SESSION["overdraftLimit"])) echo $_SESSION["overdraftLimit"]; ?>"
                   placeholder="Overdraft limit" disabled>
        </div>

        <!-- a div which groups the buttons -->
        <div class="myButton">
            <!-- the submit button -->
            <input class="button" type="submit" value="Close current account">
            <!-- TODO cancel button doesn't clear the options in the accounts datalist (or anything) -->
            <!-- the reset button -->
            <input class="button" type="reset" value="Cancel" onclick="cancel()">
        </div>

        <input type="hidden" name="confirmed" id="confirmed" value="0">

        <!-- paragraph that will be used to display a message to the user after submitting the form -->
        <p class="display">
            <?php
            // checks if there is a message and displays it
            if (isset($_SESSION["message"])) echo $_SESSION["message"];
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
</main>
</body>

</html>