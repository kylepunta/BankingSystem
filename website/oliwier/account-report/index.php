<?php session_start(); // start the session
?>

<!--
Author  : Oliwier Jakubiec
Date    : Mar 2025
ID      : C00296807
Name    : index.php
Purpose : Main page for account report  
-->

<!-- html -->
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
    <script src="script.js"></script>
</head>

<!-- body of file -->

<body>
    <!-- include the sidemenu -->
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html');

    // if the view accounts button has been clicked then set the session vars to the values of the form
    // this is done beforehand so the the values are set before the table is created
    if (isset($_POST['viewAccounts'])) {
        // set the session variables
        $_SESSION['report_customerID'] = $_POST['custID'];
        $_SESSION['report_address'] = $_POST['address'];
        $_SESSION['report_dob'] = $_POST['dob'];
        $_SESSION['report_phone'] = $_POST['phone'];
    }
    ?>

    <!-- main section  -->
    <main>
        <!-- div for the form -->
        <div class="theForm">
            <h1>Account Report</h1>
            <form id="mainForm" action="./" method="post" onsubmit="return uncheckID()">
                <!-- box for customer name -->
                <!-- the text changes depending on the value of the session var 'name' -->
                <div class="inputbox">
                    <label for="custName">Customer name </label>
                    <select name='listbox' id='listbox' onchange="return populate()" value="<?php if (isset($_SESSION['report_name']))
                                                                                                echo $_SESSION['report_name'] ?>">
                        <?php include "listbox.php" ?>
                    </select>
                </div>

                <!-- input for customer ID -->
                <!-- the text changes depending on the value of the session var 'customerID' -->
                <!-- all fields are disabled  -->
                <div class="inputbox">
                    <label for="custID">Customer ID </label>
                    <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off required
                        disabled value="<?php if (isset($_SESSION['report_customerID']))
                                            echo $_SESSION['report_customerID'] ?>" />
                </div>

                <!-- box for address -->
                <!-- the text changes depending on the value of the session var 'address' -->
                <div class="inputbox">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="address" disabled
                        value="<?php if (isset($_SESSION['report_address']))
                                    echo $_SESSION['report_address'] ?>" />
                </div>

                <!-- box for date of birth -->
                <!-- the text changes depending on the value of the session var 'dob' -->
                <div class="inputbox">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" id="dob" placeholder="Date of Birth"
                        disabled value="<?php if (isset($_SESSION['report_dob']))
                                            echo $_SESSION['report_dob'] ?>" />
                </div>

                <!-- box for customer phone no. -->
                <!-- the text changes depending on the value of the session var 'phone' -->
                <div class="inputbox">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" id="phone" placeholder="phone" disabled
                        value="<?php if (isset($_SESSION['report_phone']))
                                    echo $_SESSION['report_phone'] ?>" />
                </div>

                <!-- submit button -->
                <div class="button">
                    <input type="submit" name="viewAccounts" value="View Accounts" />
                </div>

            </form> <!-- end of form -->


            <!-- php section -->
            <?php
            // if the view accounts button has been clicked then display the accounts and rest of the form
            if (isset($_POST['viewAccounts'])) {
                // include the database connection
                include '../../db.inc.php';
                // create the table
                echo "<table>
                            <thead><tr><th>Account Type</th>
                                    <th>Account ID</th>
                                    <th>Account Number</th>
                                    <th>Balance</th></tr>
                            </thead>
                                <tbody>";

                // create query for current accounts first
                $sql = "SELECT Customer.customerNo, firstName, surName, `Current Account`.accountID, `Current Account`.accountNumber, balance FROM Customer 
                    INNER JOIN `Customer/CurrentAccount` ON Customer.customerNo = `Customer/CurrentAccount`.`customerNo` 
                    INNER JOIN `Current Account` ON `Customer/CurrentAccount`.`accountId` = `Current Account`.`accountId` 
                    WHERE Customer.deletedFlag=0 AND `Current Account`.`deletedFlag` = 0 AND Customer.customerNo = '$_POST[custID]';";

                // check for sql errors
                if (!$result = mysqli_query($con, $sql)) {
                    die("Error in querying the database " . mysqli_error($con));
                }

                // if the number of rows in the result is greate than 0 then display the results
                if ($result->num_rows > 0) {
                    // loop through the results and display them in the table
                    while ($row = $result->fetch_assoc()) {
                        // get all the values from the row
                        $custNo = $row["customerNo"];
                        $fname = $row["firstName"];
                        $lname = $row["surName"];
                        $accID = $row["accountID"];
                        $accNum = $row["accountNumber"];
                        $balance = $row["balance"];
                        // create a string with all the values and current
                        $allText = "$custNo#$fname#$lname#$accID#$accNum#Current";
                        // display the row in the table
                        // set the id of the row to the string with all the row values so that it can be accessed later
                        // onclick showDetails(this) selects the row
                        echo "<tr class='accountRow' id='$allText' onclick='showDetails(this)'>
                                    <td>Current</td>
                                    <td>" . $row['accountID'] . "</td>
                                    <td>" . $row['accountNumber'] . "</td>
                                    <td>" . $row['balance'] . "</td>
                                  </tr>";
                    }
                }

                // create query for loan accounts 
                $sql = "SELECT Customer.customerNo, firstName, surName, `Loan Account`.accountID, `Loan Account`.accountNumber, balance FROM Customer 
                    INNER JOIN `Customer/LoanAccount` ON Customer.customerNo = `Customer/LoanAccount`.`customerNo` 
                    INNER JOIN `Loan Account` ON `Customer/LoanAccount`.`accountID` = `Loan Account`.`accountID` 
                    WHERE Customer.deletedFlag=0 AND `Loan Account`.`deletedFlag` =0 AND Customer.customerNo = '$_POST[custID]';";

                // check for sql errors
                if (!$result = mysqli_query($con, $sql)) {
                    die("Error in querying the database " . mysqli_error($con));
                }

                // if the number of rows in the result is greate than 0 then display the results
                if ($result->num_rows > 0) {
                    // loop through the results and display them in the table
                    while ($row = $result->fetch_assoc()) {
                        // get all the values from the row
                        $custNo = $row["customerNo"];
                        $fname = $row["firstName"];
                        $lname = $row["surName"];
                        $accID = $row["accountID"];
                        $accNum = $row["accountNumber"];
                        $balance = $row["balance"];
                        // create a string with all the values and loan
                        $allText = "$custNo#$fname#$lname#$accID#$accNum#Loan";
                        // display the row in the table
                        // set the id of the row to the string with all the row values so that it can be accessed later
                        // onclick showDetails(this) selects the row
                        echo "<tr class='accountRow' id='$allText' onclick='showDetails(this)'>
                                    <td>Loan</td>
                                    <td>" . $row['accountID'] . "</td>
                                    <td>" . $row['accountNumber'] . "</td>
                                    <td>" . $row['balance'] . "</td>
                                 </tr>";
                    }
                }
                // close the table tag
                echo "</tbody></table>";
                // close the connection
                mysqli_close($con);

                // create the form for the account report
                echo '<form action="report.php" method="POST">
                            <input type="hidden" name="accountNumber" id="accountNumber" value="" />

                            <div class="inputbox">
                                <label for="startDate">Start date (optional):</label>
                                <input type="date" name="startDate" id="startDate" />
                            </div>
                            <div class="inputbox">
                                <label for="endDate">End date (optional):</label>
                                <input type="date" name="endDate" id="endDate"/>
                            </div>';

                echo    "<div class='button'>
                                <input type='submit' value='View Report' name='View Report' id='submit' disabled/> 
                            </div>
                        </form>";
            }
            ?> <!-- end of php section -->

        </div> <!-- end of form  -->
    </main>
</body>

</html>