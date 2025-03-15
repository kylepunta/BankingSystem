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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
<?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); 
    if (ISSET($_POST['viewAccounts']) || ISSET($_POST['View Report'])) {
        include 'db.inc.php';

        $_SESSION['customerID']=$_POST['custID'];
        $_SESSION['address']=$_POST['address'];
        $_SESSION['dob']=$_POST['dob'];
        $_SESSION['phone']=$_POST['phone'];
    }
    ?>

    <script>

        // function to display a student details based on the value in listbox
        function populate() {
            // get the listbox element
            var sel = document.getElementById("listbox");
            // get the selected item in the dropdown
            var result = sel.options[sel.selectedIndex].value;

            if (result == "placeholder") {
                // if the placeholder is selected clear the fields
                document.getElementById("custID").value = "";
                document.getElementById("address").value = "";
                document.getElementById("dob").value = "";
                document.getElementById("phone").value = "";
            
                return;
            }
            // make an array of the student details by splitting the result by the delimitter ','
            var personDetails = result.split('#');
            // display the details in the <p> tag
            console.log(personDetails);
            // get elements and display the results in the array
        
            document.getElementById("custID").value = personDetails[0];
            document.getElementById("address").value = personDetails[1];
            document.getElementById("dob").value = personDetails[2];
            document.getElementById("phone").value = personDetails[3];
    

        }
        function uncheckID() {
            document.getElementById("custID").disabled = false;
            document.getElementById("address").disabled = false;
            document.getElementById("dob").disabled = false;
            document.getElementById("phone").disabled = false;
            return true;
        }

        function showDetails(element) {

            if(element.classList.contains("selectedAccount")) {
                element.classList.remove("selectedAccount");
                document.getElementById("submit").disabled = true;
                document.getElementById("accountNumber").value = "";
                return;
            }

            var array = document.getElementsByClassName("accountRow");
            for (var i = 0; i < array.length; i++) {
                array[i].classList.remove("selectedAccount")
            }

            element.classList.add("selectedAccount");
            document.getElementById("submit").disabled = false;
            document.getElementById("accountNumber").value = element.id;
        }
       
    </script>
    <main>
    
    <div class="theForm">
        <h1>Account Report</h1>
    <form id="mainForm" action="index.php" method="post" onsubmit="return uncheckID()">
        <!-- box for customer name -->
        <!-- the text changes depending on the value of the session var 'name' -->
        <div class="inputbox">
            <label for="custName">Customer name </label>
            <select name='listbox' id ='listbox' onclick ="return populate()" value="<?php if (ISSET($_SESSION['name']) ) echo $_SESSION['name']?>">
                <?php include "listbox.php" ?>
            </select>
        </div>

        <!-- input for customer ID -->
        <div class="inputbox">
            <label for="custID">Customer ID </label>
            <input type="number" name="custID" id="custID" placeholder="custID" autocomplete=off required disabled
            value="<?php if (ISSET($_SESSION['customerID']) ) echo $_SESSION['customerID']?>"/>    <!-- if the session var 'personid' is set echo that person id -->
        </div>

        <!-- box for address -->
        <!-- the text changes depending on the value of the session var 'address' -->
        <div class="inputbox">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="address" disabled 
            value="<?php if (ISSET($_SESSION['address']) ) echo $_SESSION['address']?>"/>
        </div>

        <!-- box for date of birth -->
        <!-- the text changes depending on the value of the session var 'dob' -->
        <div class="inputbox">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" disabled 
            value="<?php if (ISSET($_SESSION['dob']) ) echo $_SESSION['dob']?>"/>
        </div>

        <!-- box for customer phone no. -->
        <!-- the text changes depending on the value of the session var 'phone' -->
        <div class="inputbox">
            <label for="phone">Phone number</label>
            <input type="text" name="phone" id="phone" placeholder="phone" disabled
            value="<?php if (ISSET($_SESSION['phone']) ) echo $_SESSION['phone']?>"/>
        </div>

        <!-- submit button -->
         <div class="button">

             <input type="submit" name="viewAccounts" value="View Accounts"/>
        </div>

    </form>

    
    <!-- php section -->
    <?php
        if (ISSET($_POST['viewAccounts']) || ISSET($_POST['View Report'])) {
            include 'db.inc.php';

            echo "<table><thead><tr><th>Account Type</th><th>Account ID</th><th>Account Number</th><th>Balance</th></tr></thead><tbody>";
            // create query for current accounts first
            $sql = "SELECT Customer.customerNo, firstName, surName, `Current Account`.accountID, `Current Account`.accountNumber, balance FROM Customer 
            INNER JOIN `Customer/CurrentAccount` ON Customer.customerNo = `Customer/CurrentAccount`.`customerNo` 
            INNER JOIN `Current Account` ON `Customer/CurrentAccount`.`accountId` = `Current Account`.`accountId` 
            WHERE Customer.deletedFlag=0 AND `Current Account`.`deletedFlag` = 0 AND Customer.customerNo = '$_POST[custID]';";
            
            if (!$result = mysqli_query($con, $sql)) {
                die("Error in querying the database " . mysqli_error($con));
            }
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $custNo = $row["customerNo"];
                    $fname = $row["firstName"];
                    $lname = $row["surName"];
                    $accID = $row["accountID"];
                    $accNum = $row["accountNumber"];
                    $balance = $row["balance"];
                    $allText = "$custNo#$fname#$lname#$accID#$accNum#Current";
                   
                    echo "<tr class='accountRow' id='$allText' onclick='showDetails(this)'><td>Current</td><td>".$row['accountID']."</td><td>".$row['accountNumber']."</td><td>".$row['balance']."</td></tr>"; 
                }
                 
            
            }
            // create query for loan accounts 
            $sql = "SELECT Customer.customerNo, firstName, surName, `Loan Account`.accountID, `Loan Account`.accountNumber, balance FROM Customer 
            INNER JOIN `Customer/LoanAccount` ON Customer.customerNo = `Customer/LoanAccount`.`customerNo` 
            INNER JOIN `Loan Account` ON `Customer/LoanAccount`.`accountID` = `Loan Account`.`accountID` 
            WHERE Customer.deletedFlag=0 AND `Loan Account`.`deletedFlag` =0 AND Customer.customerNo = '$_POST[custID]';";
            
            if (!$result = mysqli_query($con, $sql)) {
                die("Error in querying the database " . mysqli_error($con));
            }

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $custNo = $row["customerNo"];
                    $fname = $row["firstName"];
                    $lname = $row["surName"];
                    $accID = $row["accountID"];
                    $accNum = $row["accountNumber"];
                    $balance = $row["balance"];
                    $allText = "$custNo#$fname#$lname#$accID#$accNum#Loan";

                    echo "<tr class='accountRow' id='$allText' onclick='showDetails(this)'><td>Loan</td><td>".$row['accountID']."</td><td>".$row['accountNumber']."</td><td>".$row['balance']."</td></tr>"; 
                }
            }
            echo "</tbody></table>";    
            // close the connection
            mysqli_close($con);
            echo '<form action="confirmAcc.php" method="POST">
                <input type="hidden" name="accountNumber" id="accountNumber" value="" />

                <div class="inputbox">
                <label for="startDate">Start date (optional):</label>
                <input type="date" name="startDate" id="startDate" />
                </div>
                <div class="inputbox">
                <label for="endDate">End date (optional):</label>
                <input type="date" name="endDate" id="endDate"/>
                </div>';

            echo "<div class='button'>
                    <input type='submit' value='View Report' name='View Report' id='submit' disabled/> 
                </div>
                </form>";
        }
    ?>
    </div>
    </main>
</body>
</html>