<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="./script.js"></script>
</head>
<body>
	<?php require('../../sideMenu.html'); ?>
    <main>
        <h1>Close a deposit account</h1>
        <form action="processForm.php" method="post" onsubmit="return false">
            <div class="inputbox">
                <label>Choose a customer:</label>
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
                <input type="text" name="name" id="name" readonly required value="<?php if (ISSET($_SESSION['closename'])) echo $_SESSION['closename'] ?>" title="Please choose a customer by name or id above"/>
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
            <div><p id="message"></p></div>
            <div class="buttons">
                <input type="submit" value="Close account" id="closeAccountButton" name="closeAccount">
            </div>
        </form>



        
        <?php 
        if (!ISSET($_SESSION['closename']) and ISSET($_SESSION['closecustNumber'])) {
            echo '<p style="color: red; text-align: center; font-size: 20">
            No record found for a person with id: ' . $_SESSION['number'] . '<br>Please try again!</p>';
            unset($_SESSION['number']); 
        }?>
    </main>
</body>
</html>