<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account -->
<?php
// start a session
session_start();
// initialises the error message so it can be concatenated to
if (!isset($_SESSION["errorMsg"])) $_SESSION["errorMsg"] = "";
// declares that these variables are from another file and globally available
global $validId;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Open Current Account</title>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/head.html'); ?>
    <link rel="stylesheet" href="/darian/darianStyles.css">
    <script src="/darian/darianScript.js"></script>
    <script src="open.js"></script>
</head>

<body>
<?php
// adds the side menu to the page
require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');

// checks that a customerId was POSTed
if (!empty($_POST["cid"])) {
    // checks that the user confirmed and an account number was generated
    // and an overdraft limit and initial balance was entered
    if (!empty($_POST["confirmed"]) && !empty($_SESSION["accountno"])
        && isset($_POST["overdraftlimit"]) && isset($_POST["initbal"])) {
        // continue to open current account
        require("open.php");
    } else {
        // query customer details
        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');

        // checks that the id entered was valid
        if ($validId) {
            // requires code that can generate a random account number
            require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountno.inc.php');
            // checks if an account number was already generated, generates a new one if not
            if (!isset($_SESSION["accountno"])) $_SESSION["accountno"] = generateAccountNo();
        } else {
            // clears the random account number so it isn't displayed on the form
            unset($_SESSION["accountno"]);
        }
    }
} else {
    // no customerId was POSTed so clear the values so they aren't displayed on the form
    unset($_SESSION["accountno"]);
    unset($_SESSION["address"]);
    unset($_SESSION["eircode"]);
    unset($_SESSION["dob"]);
}
?>
<main>
    <form action="./" onsubmit="return confirmSubmit()" method="post">
        <!-- the heading of the form -->
        <h2>Open Current Account</h2>

        <!-- contains the labels and inputs for a customer -->
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.html.php') ?>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="accountno">Account number:</label>
            <!-- the accountno input box -->
            <input type="text" name="accountno" id="accountno"
                   value="<?php if (isset($_SESSION["accountno"])) echo $_SESSION["accountno"] ?>"
                   placeholder="Account number" disabled>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="overdraftlimit">Overdraft limit:</label>
            <!-- the overdraftlimit input box -->
            <input type="number" name="overdraftlimit" id="overdraftlimit" placeholder="Overdraft limit"
                   title="0 for no overdraft" min="0" step="0.01" required>
        </div>

        <!-- a div which groups the input box and it's label -->
        <div class="inputbox">
            <label for="initbal">Initial Deposit:</label>
            <!-- the initbal input box -->
            <input type="number" name="initbal" id="initbal" placeholder="Initial Deposit"
                   title="0 for no initial deposit" min="0" step="0.01" required>
        </div>

        <!-- a div which groups the buttons -->
        <div class="myButton">
            <!-- the submit button -->
            <input class="button" type="submit" value="Open current account">
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
</main>
</body>

</html>