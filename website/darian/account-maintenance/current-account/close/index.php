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
    // TODO only display current account details, currently displays deposit and current accounts

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

    // A you provide an account no
    // B you provide a customer no
    // C you provide both, account number must match customer
    // D you provide an account no and you confirm to close the account
    // E you provide an account no and it's invalid

    $gotAccountNo = !empty($_POST["accountno"]);
    $gotCustomerId = !empty($_POST["cid"]);

    if ($gotAccountNo && $gotCustomerId) {
        // C you provide both, account number must match customer

        require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
        global $con;

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

        $theymatch = mysqli_num_rows($result) != 0;

        if ($theymatch) {
            // echo $_POST["accountno"] . " belongs to customer " . $_POST["cid"];
            // display both account details and customer details

            require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
            // if ($validAccount) {
            require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
            // } else {
            //     unset($_SESSION["address"]);
            //     unset($_SESSION["eircode"]);
            //     unset($_SESSION["dob"]);
            // }
        } else {
            // echo $_POST["accountno"] . " doesnt belong to customer " . $_POST["cid"];
            // display only customer details, clear previous account details

            require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');

            clearPreviousAccount();
        }
    } else if ($gotAccountNo) {
        // A you provide an account number

        // show account details, shows it's customers details
        // echo "showing account details for " . $_POST["accountno"];
        // echo "showing customer details for that account...";

        require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
        if ($validAccount) {
            require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
        } else {
            clearPreviousCustomer();
        }
    } else if ($gotCustomerId) {
        // B you provide a customer no
        // echo "showing customer details for " . $_POST["cid"];

        // echo "clear previous account details";

        require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');

        clearPreviousAccount();
    } else {
        // echo "clear previous customer and account details";

        clearPreviousCustomer();
        clearPreviousAccount();
    }

    // require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
    // if ($validAccount) {
    //     require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
    // }

    //TODO idk if this works
    // if (isset($_POST["confirmed"]) && $_POST["confirmed"] == "1" && $gotCustomerId && $gotAccountNo) {
    //     // D you provide an account no and you confirm to close the account
    //     // close account
    //     echo $_POST["accountno"] . "account closed";
    // }

    //     if (!empty($_POST["accountno"]) && !empty($_POST["cid"]) && $_POST["confirmed"] == "1") {
    // //        continue to close current account
    // //             require("close.php");
    //         ECHO "all details for closure receieved... closing";
    //     } else if (!empty($_POST["accountno"]) && empty($_POST["cid"])) {
    //         ECHO "account number, no customer id";
    //         // query account details
    //         require($_SERVER["DOCUMENT_ROOT"] . '/darian/accountDetails.inc.php');
    //
    //         if ($validAccount) {
    //             require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
    //
    //             if (!$validId) {
    //                 unset($_SESSION["address"]);
    //                 unset($_SESSION["eircode"]);
    //                 unset($_SESSION["dob"]);
    //             }
    //         } else {
    //             unset($_SESSION["balance"]);
    //             unset($_SESSION["overdraftLimit"]);
    //         }
    //     } else if (!empty($_POST["cid"]) && empty($_POST["accountno"])) {
    //         ECHO "customer id, no account number";
    // //        query customer details
    //         require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerDetails.inc.php');
    //
    //         if (!$validId) {
    //             unset($_SESSION["address"]);
    //             unset($_SESSION["eircode"]);
    //             unset($_SESSION["dob"]);
    //         }
    //     } else {
    //         ECHO "default";
    //         unset($_SESSION["balance"]);
    //         unset($_SESSION["overdraftLimit"]);
    //         unset($_SESSION["address"]);
    //         unset($_SESSION["eircode"]);
    //         unset($_SESSION["dob"]);
    //     }
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