<!--
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A HTML/PHP file that presents the user with a form to delete a customer
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <!-- <link rel="stylesheet" href="./customer.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php require('../sideMenu.html'); // includes the side nav element in sideMenu.html 
    ?>
    <main>
        <form action="./delete-customer.php" method="post" id="delete-customer-form"> <!--Delete Customer form-->
            <h1>Delete a Customer</h1>
            <h4>Select a customer from the database, then click delete to delete the customer.</h4>
            <p>
                <label for="select-customer">Select a customer</label>
                <select name="customerDropdown" id="select-customer">
                    <?php // renders all customers from the Customer table in the database as option elements
                    include "../db.inc.php"; // connects to the database

                    if (!$con) { // throws a connection error if connection fails
                        die("Database connection failed" . mysqli_connect_error());
                    }

                    $sql = "SELECT customerNo, firstName, surName FROM Customer WHERE deletedFlag=0";
                    $result = mysqli_query($con, $sql); // executes the SQL query
                    if (!$result) {
                        // throws an error if the SQL query fails
                        die("Error in querying the database" . mysqli_error($con));
                    }

                    if (mysqli_num_rows($result) === 0) {
                        // throws an error if no rows are selected
                        die("No customers found in the Customer table");
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        // creates an option element for each customer by appending values from each result row
                        $customerID = $row['customerNo'];
                        $firstName = $row['firstName'];
                        $surname = $row['surName'];
                        echo "<option value='{$customerID}'>{$customerID} - {$firstName} {$surname}</option>";
                    }

                    mysqli_close($con); // closes the database connection
                    ?>
                </select>
            </p>
            <div class="form-buttons">
                <input type="submit" value="Confirm Selection" id="confirm-button">
            </div>
        </form>
    </main>
    <script src="./deleteCustomer.js"></script> <!--Links the deleteCustomer.js file-->
</body>

</html>