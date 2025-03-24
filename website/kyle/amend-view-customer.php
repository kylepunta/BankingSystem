<!--
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A PHP file that presents the user with a form to amend and/or view a customer
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return to Amend/View a Customer</title>
    <link rel="stylesheet" href="./customer.css">
    <link rel="stylesheet" href="../commonStyles.css">
</head>

<body>
    <?php require('../sideMenu.html'); ?>
    <main>
        <form action="amend-view-customer.php" method="post" id="amend-view-customer-form">
            <p>
                <label for="select-customer">Select a customer</label>
                <select name="customer-dropdown" id="select-customer">
                    <?php include('./listbox.php') ?>
                </select>
            </p>
            <p class="amend-view-button-container">
                <input type="button" value="Amend Details" id="amend-view-button">
            </p>
            <p>
                <label for="customerID">Customer ID</label>
                <input type="text" name="customerID" id="customerID">
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
                <label for="eircode">Eircode</label>
                <input type="text" name="eircode" id="eircode" required>
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
                <label for="occupation">Occupation</label>
                <input type="text" name="occupation" id="occupation" required>
            </p>
            <p>
                <label for="salary">Salary</label>
                <input type="text" name="salary" id="salary" required>
            </p>
            <p>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>
            </p>
            <p>
                <label for="guarantorName">Guarantor's Name (if applicable)</label>
                <input type="text" name="guarantorName" id="guarantorName">
            </p>
            <p class="form-buttons">
                <input type="submit" value="Submit" id="submit">
                <input type="reset" value="Clear" id="reset">
            </p>
        </form>

        <div class="result-container">
            <?php

            include "../db.inc.php";
            $dbDate = date("Y-m-d", strtotime($_POST['dateOfBirth']));

            $query = "UPDATE Customer SET 
            firstName='$_POST[firstName]', surName='$_POST[lastName]', address='$_POST[address]', 
            eircode='$_POST[eircode]', dateOfBirth='$_POST[dateOfBirth]', telephoneNo='$_POST[phoneNumber]', 
            occupation='$_POST[occupation]', salary='$_POST[salary]', emailAddress='$_POST[email]', 
            guarantorName='$_POST[guarantorName]' WHERE customerNo='$_POST[customerID]'";

            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Error submitting query to the database" . mysqli_error($con));
            }

            if (mysqli_affected_rows($con) != 0) {
                echo "<h2>";
                echo mysqli_affected_rows($con) . " record(s) updated";
                echo "</h2>";
            } else {
                echo "<h2>No records were changed</h2>";
            }

            mysqli_close($con);

            ?>

            <form action="./amend-view-customer.html.php" method="post" class="close-window">
                <button type="submit" id="return-button">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>window-close</title>
                            <path d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                        </svg>
                    </div>
                </button>
            </form>
        </div>
    </main>
    <script>
        document.querySelector("nav").classList.add("disabled");
        document.querySelector("#amend-view-customer-form").classList.add("disabled");
    </script>
</body>

</html>