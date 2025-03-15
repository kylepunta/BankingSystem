<?php session_start(); // start the session
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="accountRep.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');
    $_SESSION['accountNumber'] = $_POST['accountNumber'];
    ?>
    <main>
        <?php
        include 'db.inc.php';
        echo "<h1>Account Report</h1>";
        //echo "<h2>Info: " . $_POST['accountNumber'] . $_POST['startDate']. $_POST['endDate']. "</h2>";
        //customerNo firstName surName accountId accountNum balance
        $accountInfo = explode("#", $_POST['accountNumber']);
        
        $customerNo = $accountInfo[0];
        $name = $accountInfo[1] . " " . $accountInfo[2];
        $accountId = $accountInfo[3];
        $accountNum = $accountInfo[4];
        $accountType = $accountInfo[5];

        echo "<div class='report'>";
        $dateMinus6months = date("Y-m-d", strtotime("-6 months"));
        $today = date("Y-m-d");
        // check to see if the account is a current account or a loan account
        if ($accountType == "Current") {
            echo "<u>Current Account</u><br><br>";
            echo "<div style='display: flex; justify-content: space-between;'>
                    <p>Account Number: $accountNum</p>
                    <p>Customer Name: $name</p>
                    </div>";
            // check to see what time frame the user has selected
            if ($_POST['startDate'] == "" && $_POST['endDate'] == "") {
                $timeFrame = "AND date BETWEEN '$dateMinus6months' AND '$today'";
            } else if ($_POST['startDate'] == "") {
                $timeFrame = "AND date >= '" . $_POST['endDate'] . "'";
            } else if ($_POST['endDate'] == "") {
                $timeFrame = "AND date <= '" . $_POST['startDate'] . "'";
            } else {
                $timeFrame = "AND date BETWEEN '" . $_POST['endDate'] . "' AND '" . $_POST['startDate'] . "'";
            }
            $sql = "SELECT * FROM `Current Account History` WHERE accountId='$accountId' $timeFrame ORDER BY `Current Account History`.date ASC;";
            //echo $sql;
            if (!$result = mysqli_query($con, $sql)) {
                die('Error in querying the database ' . mysqli_error($con));
            }

            if (mysqli_affected_rows($con) == 0) {
                // if no transactions found display message
                echo "<p id='message'>No transactions found within the selected time frame.<br>Please try with different dates</p>";
            } else {
                // if transactions found display table of transactions
                echo "<table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    $date = date_create($row['date']);
                    $date = date_format($date,"d-m-Y");
                    echo "<tr><td>".$date."</td><td>".$row['transactionType']."</td><td>".$row['amount']."</td><td>".$row['balance']."</td></tr>";
                }
                echo "</tbody></table>";
            }

        } else { 
            echo "<u>Loan Account</u><br><br>";
            echo "<div style='display: flex; justify-content: space-between;'>
                    <p>Account Number: $accountNum</p>
                    <p>Customer Name: $name</p>
                    </div>";
            // check to see what time frame the user has selected
            if ($_POST['startDate'] == "" && $_POST['endDate'] == "") {
                $timeFrame = "AND transactionDate BETWEEN '$dateMinus6months' AND '$today'";
            } else if ($_POST['startDate'] == "") {
                $timeFrame = "AND transactionDate >= '" . $_POST['endDate'] . "'";
            } else if ($_POST['endDate'] == "") {
                $timeFrame = "AND transactionDate <= '" . $_POST['startDate'] . "'";
            } else {
                $timeFrame = "AND transactionDate BETWEEN '" . $_POST['endDate'] . "' AND '" . $_POST['startDate'] . "'";
            }
            $sql = "SELECT * FROM `Loan Account History` WHERE accountId='$accountId' $timeFrame ORDER BY `Loan Account History`.transactionDate ASC;";
            //echo $sql;

            if (!$result = mysqli_query($con, $sql)) {
                die("Error in querying the database " . mysqli_error($con));
            }
            
            echo "<table><thead><tr><th>Date</th><th>Transaction Type</th><th>Transaction Amount</th><th>Balance</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_array($result)) {
                $date = date_create($row['transactionDate']);
                $date = date_format($date,"d-m-Y");
                echo "<tr><td>".$date."</td><td>".$row['transactionType']."</td><td>".$row['repaymentAmount']."</td><td>".$row['balance']."</td></tr>";
            }
            echo "</tbody></table>";
        }
        echo "</div>";
        mysqli_close($con);

    ?>
    <form action="index.php" method="post">
        <div class="button">
            <input type="submit" value="Back">
        </div>
    </form>
</main>
</body>
</html>