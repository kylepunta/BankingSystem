<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="./customer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php require('../sideMenu.html'); ?>
    <main>
        <form action="./delete-customer.html.php" method="post" id="delete-customer-form">
            <p>
                <label for="select-customer">Select a customer</label>
                <select name="customerDropdown" id="select-customer">
                    <?php
                    include "../db.inc.php";

                    if (!$con) {
                        die("Database connection failed" . mysqli_connect_error());
                    }

                    $sql = "SELECT customerNo, firstName, surName FROM Customer WHERE deletedFlag=0";
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                        die("Error in querying the database" . mysqli_error($con));
                    }

                    if (mysqli_num_rows($result) === 0) {
                        die("No customers found in the Customer table");
                    }

                    echo "Connected to database.";
                    echo "<br>Query executed successfully.";

                    while ($row = mysqli_fetch_array($result)) {
                        $customerID = $row['customerNo'];
                        $firstName = $row['firstName'];
                        $surname = $row['surName'];
                        echo "<option value='{$customerID}'>{$customerID} - {$firstName} {$surname}</option>";
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </p>
            <div class="form-buttons">
                <input type="submit" value="Confirm Selection" id="confirm-button">
            </div>
        </form>
        <div class="result-container">
            <?php
            include "../db.inc.php";
            echo "$_POST[customerdropdown]";
            $query = "UPDATE Customer SET deletedFlag=1 WHERE customerNo='$_POST[customerDropdown]'";
            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Error querying the database" . mysqli_error($con));
                echo "<h2>No records were deleted from the database</h2>";
            }

            echo "<h2>1 record deleted from the database</h2>";


            mysqli_close($con);
            ?>
            <form action="./delete-customer.html.php" method="post" class="close-window">
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
        document.querySelector("#delete-customer-form").classList.add("disabled");
    </script>
</body>

</html>