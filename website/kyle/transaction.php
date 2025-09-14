<?php require_once '../config.php';
/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A HTML/PHP file that displays the result of a lodgement attempt 
*/

// when user submits the form and values are posted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accountType'])) {
    $_SESSION['accountType'] = $_POST['accountType']; // creates PHP session variables
    $_SESSION['selectedAccount'] = $_POST['account-dropdown'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lodgements</title>
    <?php require("../head.html") // links the head.html file 
    ?>
    <!-- <link rel="stylesheet" href="./customer.css" /> -->
</head>

<body>
    <?php require("../sideMenu.html") // includes the side nav element in sideMenu.html 
    ?>
    <main>
        <h1>Transaction Page</h1>
        <form action="./lodgements.html.php" method="post" name="lodgementsForm" id="lodgements-form">
            <p>
                <label for="account-type">Select an account type</label>
                <select name="accountType" id="account-type">
                    <!--If the session variable accountType is equal to the account type, it selects the option element-->
                    <option value="currentAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'currentAccount') ? 'selected' : '' ?>>Current Account</option>
                    <option value="depositAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'depositAccount') ? 'selected' : '' ?>>Deposit Account</option>
                    <option value="loanAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'loanAccount') ? 'selected' : '' ?>>Loan Account</option>
                </select>
            </p>
            <p>
                <label for="account-dropdown">Select an account</label>
                <select name="account-dropdown" id="account-dropdown">
                    <?php require("./lodgementsListbox.php") // renders the customer accounts 
                    ?>
                </select>
            </p>
            <p>
                <label for="customerID">Customer ID</label>
                <input type="text" name="customerID" id="customerID">
            </p>
            <p>
                <label for="accountNumber">Account Number</label>
                <input type="text" name="accountNumber" id="accountNumber">
            </p>
            <p>
                <label for="accountID">Account ID</label>
                <input type="text" name="accountID" id="accountID">
            </p>
            <p>
                <label for="balance">Balance</label>
                <input type="text" name="balance" id="balance">
            </p>
            <p>
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </p>
            <p>
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </p>
            <p>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" required>
            </p>
            <p>
                <label for="dateOfBirth">Date of Birth</label>
                <input type="date" name="dateOfBirth" id="dateOfBirth" required>
            </p>
            <p>
                <label for="phoneNumber">Telephone Number</label>
                <input type="text" name="phoneNumber" id="phoneNumber" required>
            </p>
            <p>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>
            </p>
            <p>
                <label for="lodgementAmount">Lodgement Amount</label>
                <input type="text" name="lodgementAmount" id="lodgementAmount">
            </p>
            <div class="form-buttons">
                <input type="submit" value="Confirm" id="submitBtn" name="submitBtn">
            </div>
        </form>
        <div class="result-container"> <!--Container that displays the result of the SQL query-->
            <?php
            include "../db.inc.php"; // connects to the database

            $accountType = $_POST['accountType'] ?? null; // assigns accountType the posted value, otherwise assigns null
            $newBalance = 0; // declare variable newBalance with value of 0

            // check if balance, lodgementAmount and accountID have been posted
            if (isset($_POST['balance'], $_POST['lodgementAmount'], $_POST['accountID'])) {
                // creates SQL query statement for the corresponding selected account type
                switch ($accountType) {
                    case "currentAccount":
                        // new balance is calculated by adding the previous balance and lodgement amount
                        $newBalance = $_POST['balance'] + $_POST['lodgementAmount'];
                        $sql = "UPDATE `Current Account` SET balance='$newBalance' WHERE accountId='$_POST[accountID]'";
                        break;
                    case "depositAccount":
                        // new balance is calculate by adding the previous balance and lodgement amount
                        $newBalance = $_POST['balance'] + $_POST['lodgementAmount'];
                        $sql = "UPDATE `Deposit Account` SET balance='$newBalance' WHERE accountID='$_POST[accountID]'";
                        break;
                    case "loanAccount":
                        // new balance is calculate by subtracting the lodgement amount from the previous balance
                        $newBalance = $_POST['balance'] - $_POST['lodgementAmount'];
                        $sql = "UPDATE `Loan Account` SET balance='$newBalance' WHERE accountID='$_POST[accountID]'";
                        break;
                }
            }
            $result = mysqli_query($con, $sql); // executes the SQL query

            if (!$result) { // throws an error if SQL query is unsuccessful
                die("Error querying the database" . mysqli_error($con));
            }

            // if at least one row is updated in the table
            if (mysqli_affected_rows($con) != 0) {
                echo "<h2>Lodgement Successful! New Balance: $newBalance</h2>";
            } else { // if no rows are updated in the table
                echo "<h2>Lodgement Unsuccessful</h2>";
            }

            $todayDate = date("Y-m-d"); // creates a today's date object that matches the database table format

            // if SQL query is successful and at least one row was updated in the table
            if ($result && mysqli_affected_rows($con) != 0) {
                // Inserts an account history entry for the corresponding account type
                switch ($accountType) {
                    case "currentAccount":
                        $sql = "INSERT INTO `Current Account History` (accountId, date, transactionType, amount, balance) VALUES ('$_POST[accountID]', '$todayDate', 'Lodgement', '$_POST[lodgementAmount]', '$newBalance')";
                        break;
                    case "depositAccount":
                        $sql = "INSERT INTO `Deposit Account History` (accountId, date, transactionType, transactionAmount, balance) VALUES ('$_POST[accountID]', '$todayDate', 'Lodgement', '$_POST[lodgementAmount]', '$newBalance')";
                        break;
                    case "loanAccount":
                        $sql = "INSERT INTO `Loan Account History` (accountID, transactionDate, transactionType, repaymentAmount, balance) VALUES ('$_POST[accountID]', '$todayDate', 'Lodgement', '$_POST[lodgementAmount]', '$newBalance')";
                        break;
                }
            }
            $result = mysqli_query($con, $sql); // executes the SQL query

            if (!$result) { // throws an error if the SQL query is unsuccessful
                die("Error querying the database" . mysqli_error($con));
            }

            ?>
            <!--Close window button wrapped in a form element that returns to the previous screen-->
            <form action="./lodgements.html.php" method="post" class="close-window">
                <button type="submit" id="return-button">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>window-close</title>
                            <path d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                        </svg>
                    </div>
                </button>
            </form>
        </div>
    </main>
</body>

</html>