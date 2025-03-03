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
<body onload="toggleInputs()">
	<?php require('../../sideMenu.html'); ?>
    <main>
        <h1>Open a deposit account</h1>
        <form action="processForm.php" method="post" onsubmit="return confirmSubmit()">
            <div class="inputbox">
                <label>Choose a customer:</label>
                <?php require('./dropdownBox.php') ?>
            </div>  
            <div class="inputbox">
                <label for="number">Customer number:</label>
                <input type="text" name="number" id="number" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['number'])) echo $_SESSION['number'] ?>"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Check customer details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (ISSET($_SESSION['name'])) echo $_SESSION['name'] ?>" title="Please choose a customer by name or id above"/>
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (ISSET($_SESSION['address'])) echo $_SESSION['address'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (ISSET($_SESSION['eircode'])) echo $_SESSION['eircode'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (ISSET($_SESSION['dob'])) echo $_SESSION['dob'] ?>"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Confirm details" id="confirmCustomerButton" name="confirmDetails">
            </div>
        </form>
        <form action="addCustomer.php" method="post" onsubmit="return finalCheck()">
            <div class="inputbox">
                <label for="accNo">Generated account no:</label>
                <input type="text" name="accNo" id="accNo" readonly required value="<?php if (ISSET($_SESSION['accNo'])) echo $_SESSION['accNo'] ?>" title="Please confirm customer details to generate an account no"/>
            </div>
            <div class="inputbox">
                <label for="balance">Opening balance:</label>
                <input type="text" name="balance" id="balance" disabled required pattern="[0-9]+[.][0-9]{2}" title="Number must match format XX.XX"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Add new account" id="submitCustomer" disabled>
            </div>
        </form>
        <?php 
        if (!ISSET($_SESSION['name']) and ISSET($_SESSION['number'])) {
            echo '<p style="color: red; text-align: center; font-size: 20">
            No record found for a person with id: ' . $_SESSION['number'] . '<br>Please try again!</p>';
            unset($_SESSION['number']); 
        }?>
    </main>
</body>
</html>