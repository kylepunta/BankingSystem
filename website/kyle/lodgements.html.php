<!--
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A HTML/PHP file that presents the user with a form to make a lodgement into an account
-->

<?php session_start();
// when user submits the form and values are posted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accountType'], $_POST['account-dropdown'])) {
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
    <link rel="stylesheet" href="./customer.css" />
</head>

<body>
    <?php require("../sideMenu.html") // includes the side nav element in sideMenu.html 
    ?>
    <main>
        <form action="./lodgements.php" method="post" name="lodgementsForm" id="lodgements-form">
            <p class="select-account-type">
                <label for="account-type">Select an account type</label>
                <select name="accountType" id="account-type">
                    <!--If the session variable accountType is equal to the account type, it selects the option element-->
                    <option value="currentAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'currentAccount') ? 'selected' : '' ?>>Current Account</option>
                    <option value="depositAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'depositAccount') ? 'selected' : '' ?>>Deposit Account</option>
                    <option value="loanAccount" <?php echo (isset($_SESSION['accountType']) && $_SESSION['accountType'] == 'loanAccount') ? 'selected' : '' ?>>Loan Account</option>
                </select>
            </p>
            <p class="select-account">
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
    </main>

    <script src="./lodgement.js"></script> <!--Links the lodgement.js file-->
</body>

</html>