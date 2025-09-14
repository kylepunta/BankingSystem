<?php require_once '../../config.php'; // start the session
?>

<!--
Author  : Oliwier Jakubiec
Date    : Mar 2025
Name    : confirmAcc.php
Purpose : confirm the account and displau the report for the account  
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Report</title>
    <!-- important css stuff for the sidemenu -->
    <?php require('../../head.html') ?>
    <!-- css file -->
    <link rel="stylesheet" href="../oliwierStyles.css">
    <!-- javascript file -->
    <script src="./script.js"></script>
</head>

<!-- body -->

<body>
    <!-- include sidemenu -->
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>
    <main>
        <?php
        // include db connection
        include '../../db.inc.php';
        echo "<h1>Account Report</h1>";
        // split the acount info back into an array
        //customerNo firstName surName accountId accountNum balance
        $accountInfo = explode("#", $_POST['accountNumber']);

        // get the values from the array
        $customerNo = $accountInfo[0];
        $name = $accountInfo[1] . " " . $accountInfo[2];
        $accountId = $accountInfo[3];
        $accountNum = $accountInfo[4];
        $accountType = $accountInfo[5];

        // create the div for the report
        echo "<div class='report'>";
        // get the date 6 months ago and today
        $dateMinus6months = date("Y-m-d", strtotime("-6 months"));
        $today = date("Y-m-d");

        // check to see if the account is a current account or a loan account
        if ($accountType == "Current") {
            // print account info   
            echo "<u>Current Account</u><br><br>";
            echo "<div style='display: flex; justify-content: space-between;'>
                    <p>Account Number: $accountNum</p>
                    <p>Customer Name: $name</p>
                    </div>";

            // check to see what time frame the user has selected
            // if no dates are selected, set the time frame to the last 6 months
            if ($_POST['startDate'] == "" && $_POST['endDate'] == "") {
                $timeFrame = "AND date BETWEEN '$dateMinus6months' AND '$today'";
            } // if start date is not selected, set the time frame to the end date selected 
            else if ($_POST['startDate'] == "") {
                $timeFrame = "AND date >= '" . $_POST['endDate'] . "'";
            } // if end date is not selected, set the time frame to the start date selected   
            else if ($_POST['endDate'] == "") {
                $timeFrame = "AND date <= '" . $_POST['startDate'] . "'";
            } // else both dates are selected, set the time frame to the dates selected 
            else {
                $timeFrame = "AND date BETWEEN '" . $_POST['endDate'] . "' AND '" . $_POST['startDate'] . "'";
            }

            // create the sql query
            $sql = "SELECT * FROM `Current Account History` WHERE accountId='$accountId' $timeFrame ORDER BY `Current Account History`.date ASC;";
            // check for sql errors
            if (!$result = mysqli_query($con, $sql)) {
                die('Error in querying the database ' . mysqli_error($con));
            }

            if (mysqli_affected_rows($con) == 0) {
                // if no transactions found display message
                echo "<p id='message'>No transactions found within the selected time frame</p>";
            } else {
                // if transactions found display table of transactions
                echo "<table>
                        <thead><tr>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Transaction Amount</th>
                            <th>Balance</th>
                        </tr></thead>
                            <tbody>";
                // while there are rows in the result, display the data in the table
                while ($row = mysqli_fetch_array($result)) {
                    // format the date to dd-mm-yyyy
                    $date = date_create($row['date']);
                    $date = date_format($date, "d-m-Y");
                    // display the data in the table
                    echo "<tr>
                            <td>" . $date . "</td>
                            <td>" . $row['transactionType'] . "</td>
                            <td>" . $row['amount'] . "</td>
                            <td>" . $row['balance'] . "</td>
                          </tr>";
                }
                // close the table
                echo "</tbody></table>";
            }
        } // else the account is a loan account 
        else {
            // print account info
            echo "<u>Loan Account</u><br><br>";
            echo "<div style='display: flex; justify-content: space-between;'>
                    <p>Account Number: $accountNum</p>
                    <p>Customer Name: $name</p>
                    </div>";

            // check to see what time frame the user has selected
            // if no dates are selected, set the time frame to the last 6 months
            if ($_POST['startDate'] == "" && $_POST['endDate'] == "") {
                $timeFrame = "AND transactionDate BETWEEN '$dateMinus6months' AND '$today'";
            } // if start date is not selected, set the time frame to the end date selected 
            else if ($_POST['startDate'] == "") {
                $timeFrame = "AND transactionDate >= '" . $_POST['endDate'] . "'";
            } // if end date is not selected, set the time frame to the start date selected   
            else if ($_POST['endDate'] == "") {
                $timeFrame = "AND transactionDate <= '" . $_POST['startDate'] . "'";
            } // else both dates are selected, set the time frame to the dates selected 
            else {
                $timeFrame = "AND transactionDate BETWEEN '" . $_POST['endDate'] . "' AND '" . $_POST['startDate'] . "'";
            }

            // create the sql query
            $sql = "SELECT * FROM `Loan Account History` WHERE accountId='$accountId' $timeFrame ORDER BY `Loan Account History`.transactionDate ASC;";

            // check for sql errors
            if (!$result = mysqli_query($con, $sql)) {
                die("Error in querying the database " . mysqli_error($con));
            }

            // create table
            echo "<table>
                    <thead><tr>
                        <th>Date</th>
                        <th>Transaction Type</th>
                        <th>Transaction Amount</th>
                        <th>Balance</th>
                    </tr></thead>
                        <tbody>";

            // while there are rows in the result, display the data in the table
            while ($row = mysqli_fetch_array($result)) {
                // format the date to dd-mm-yyyy
                $date = date_create($row['transactionDate']);
                $date = date_format($date, "d-m-Y");

                // display the data in the table
                echo "<tr>
                        <td>" . $date . "</td>
                        <td>" . $row['transactionType'] . "</td>
                        <td>" . $row['repaymentAmount'] . "</td>
                        <td>" . $row['balance'] . "</td>
                    </tr>";
            }
            // close the table
            echo "</tbody></table>";
        }
        // close the report div
        echo "</div>";
        // close the connection
        mysqli_close($con);

        ?>

        <!-- back button to send you back to customer and account selection-->
        <form action="./" method="post">
            <div class="button">
                <input type="submit" value="Back">
            </div>
        </form>

    </main>
</body>

</html>