<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Deposit Account</title>
    <?php require('../../head.html') ?>
    <link rel="stylesheet" href="../brandonStyles.css">
    <script src="./script.js"></script>
</head>
<body onload="populate()">
	<?php require('../../sideMenu.html'); ?>
    <main>
        <form action="processForm.php" method="post" id="customerDetailsForm" onsubmit="return submitCheck()">
            <h1>Close a deposit account</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <?php require('./dropdownBox.php') ?>
            </div>  
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['closecustNumber'])) echo $_SESSION['closecustNumber'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['closeaccNumber'])) echo $_SESSION['closeaccNumber'] ?>"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Check details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (ISSET($_SESSION['closename'])) echo $_SESSION['closename'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (ISSET($_SESSION['closeaddress'])) echo $_SESSION['closeaddress'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (ISSET($_SESSION['closeeircode'])) echo $_SESSION['closeeircode'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (ISSET($_SESSION['closedob'])) echo $_SESSION['closedob'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="balance">Balance:</label>
                <input type="text" name="balance" id="balance" readonly required value="<?php if (ISSET($_SESSION['closebalance'])) echo $_SESSION['closebalance'] ?>"/>
            </div>
            <p id="message"></p>
            <div class="buttons">
                <input type="submit" value="Close account" id="deleteCustomer" name="deleteCustomer" disabled>
            </div>
        </form>
		<?php 
            if (!ISSET($_SESSION['closename']) and ISSET($_SESSION['closecustNumber'])) {
                echo '<p style="color: red; text-align: center; font-size: 20">No account found with customer no: '. $_SESSION['closecustNumber'] .' and account no: '. $_SESSION['closeaccNumber'] .'!<br>Please try again!</p>';
            }
            session_destroy();
        ?>
    </main>
</body>
</html>