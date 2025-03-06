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
    <link rel="stylesheet" href="../brandonStyles.css">
    <script src="./script.js"></script>
</head>
<body onload="populate()">
	<?php require('../../sideMenu.html'); ?>
    <main>
        <form action="processForm.php" method="post" id="customerDetailsForm">
            <h1>View a deposit account</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <?php require('./dropdownBox.php') ?>
            </div>  
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['viewcustNumber'])) echo $_SESSION['viewcustNumber'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['viewaccNumber'])) echo $_SESSION['viewaccNumber'] ?>"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Check details" id="chooseCustomerButton" name="checkDetails">
            </div>
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly required value="<?php if (ISSET($_SESSION['viewname'])) echo $_SESSION['viewname'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" readonly required value="<?php if (ISSET($_SESSION['viewaddress'])) echo $_SESSION['viewaddress'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="eircode">Eircode:</label>
                <input type="text" name="eircode" id="eircode" readonly required value="<?php if (ISSET($_SESSION['vieweircode'])) echo $_SESSION['vieweircode'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="dob">Date of birth:</label>
                <input type="date" name="dob" id="dob" readonly required value="<?php if (ISSET($_SESSION['viewdob'])) echo $_SESSION['viewdob'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="balance">Balance:</label>
                <input type="text" name="balance" id="balance" readonly required value="<?php if (ISSET($_SESSION['viewbalance'])) echo $_SESSION['viewbalance'] ?>"/>
            </div>
        </form>
        <h2>Last 10 transactions:</h2>
		<?php 
            if (!ISSET($_SESSION['viewname']) and ISSET($_SESSION['viewcustNumber'])) {
                echo '<p style="color: red; text-align: center; font-size: 20">No account found with customer no: '. $_SESSION['viewcustNumber'] .' and account no: '. $_SESSION['viewaccNumber'] .'!<br>Please try again!</p>';
                session_destroy();
            } else {
                if (ISSET($_SESSION['viewname'])) {
                    require '../../db.inc.php';
                    date_default_timezone_set("UTC");

                    $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber='$_SESSION[viewaccNumber]'";
                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }

                    $row = mysqli_fetch_array($result);
                    $accID = $row['accountID'];

                    $sql = "SELECT * FROM `Deposit Account History` WHERE accountID='$accID' ORDER BY `Deposit Account History`.`date` DESC, transactionId DESC LIMIT 10";

                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }
                    echo "<table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        $date = date_create($row['date']);
                        $date = date_format($date,"Y-m-d");
                        echo "<tr><td>".$date."</td><td>".$row['transactionType']."</td><td>".$row['transactionAmount']."</td><td>".$row['balance']."</td></tr>";
                    }
                    echo "</tbody></table>";
                    mysqli_close($con);
                    session_destroy();
                } else {
                    ?>
                    <script>submitForm();</script>
                    <?php
                }
            }
        ?>
    </main>
</body>
</html>