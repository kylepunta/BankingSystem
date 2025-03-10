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
        <form action="processForm.php" method="post" id="customerDetailsForm" onsubmit="return checkDates()">
            <h1>Deposit account history</h1>
            <div class="inputbox">
                <label>Choose an account:</label>
                <?php require('./dropdownBox.php') ?>
            </div>  
            <div class="inputbox">
                <label for="custNumber">Customer number:</label>
                <input type="text" name="custNumber" id="custNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['historycustNumber'])) echo $_SESSION['historycustNumber'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="accNumber">Account number:</label>
                <input type="text" name="accNumber" id="accNumber" required pattern="[0-9]+" title="Must enter a whole number" value="<?php if (ISSET($_SESSION['historyaccNumber'])) echo $_SESSION['historyaccNumber'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="startDate">Start date (optional):</label>
                <input type="date" name="startDate" id="startDate" value="<?php if (ISSET($_SESSION['startDate'])) echo $_SESSION['startDate'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="endDate">End date (optional):</label>
                <input type="date" name="endDate" id="endDate" value="<?php if (ISSET($_SESSION['endDate'])) echo $_SESSION['endDate'] ?>"/>
            </div>
            <div class="inputbox">
                <label for="name">Customer name:</label>
                <input type="text" name="name" id="name" readonly value="<?php if (ISSET($_SESSION['endDate'])) echo $_SESSION['endDate'] ?>"/>
            </div>
            <div class="buttons">
                <input type="submit" value="Check transactions" id="chooseCustomerButton" name="checkDetails">
            </div>
        </form>
		<?php
            if (!ISSET($_SESSION['historyname']) and ISSET($_SESSION['historycustNumber'])) {
                echo '<p style="color: red; text-align: center; font-size: 20">No account found with customer no: '. $_SESSION['historycustNumber'] .' and account no: '. $_SESSION['historyaccNumber'] .'!<br>Please try again!</p>';
                session_destroy();
            } else {
                if (ISSET($_SESSION['historyname'])) {
                    require '../../db.inc.php';
                    date_default_timezone_set("UTC");

                    $sql = "SELECT accountID FROM `Deposit Account` WHERE accountNumber='$_SESSION[historyaccNumber]'";

                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }

                    $row = mysqli_fetch_array($result);
                    $accID = $row['accountID'];

                    if (ISSET($_SESSION['startDate']) && ISSET($_SESSION['endDate'])) {
                        $dateSQL = "AND date>='$_SESSION[startDate]' AND date<='$_SESSION[endDate]'";
                    } else if (ISSET($_SESSION['startDate'])) {
                        $dateSQL = "AND date>='$_SESSION[startDate]'";
                    } else if (ISSET($_SESSION['endDate'])) {
                        $dateSQL = "AND date<='$_SESSION[endDate]'";
                    } else { 
                        $dateSQL = "";
                    }

                    $sql = "SELECT * FROM `Deposit Account History` WHERE accountID='$accID' $dateSQL ORDER BY `Deposit Account History`.`date` DESC, transactionId DESC";

                    if (!$result = mysqli_query($con, $sql)) {
                        die('Error in querying the database ' . mysqli_error($con));
                    }

                    if (mysqli_affected_rows($con) == 0) {
                       echo "<p id='message'>No transactions found within the selected time frame.<br>Please try with different dates</p>";
                    } else {
                        echo "<h2>Transactions:</h2><table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            $date = date_create($row['date']);
                            $date = date_format($date,"d-m-Y");
                            echo "<tr><td>".$date."</td><td>".$row['transactionType']."</td><td>".$row['transactionAmount']."</td><td>".$row['balance']."</td></tr>";
                        }
                        echo "</tbody></table>";
                    }
                    mysqli_close($con);
                    session_destroy();
                }
            }
        ?>
    </main>
</body>
</html>