<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="./customer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php require('../sideMenu.html'); ?>
    <main>
        <form action="" method="post" id="add-customer-form">
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
            <div class="form-buttons">
                <input id="submit" type="submit" value="Submit">
                <input id="reset" type="reset" value="Clear">
            </div>
        </form>
        <div class="result-container">
            <?php
            include "../db.inc.php";
            $dbDate = date("Y-m-d", strtotime($_POST['dateOfBirth']));

            $query = "INSERT INTO `Customer` 
            (`firstName`, `surName`, `address`, `eircode`, `dateOfBirth`, `telephoneNo`, `occupation`, `salary`, 
            `emailAddress`, `guarantorName`) 
            VALUES ('$_POST[firstName]', '$_POST[lastName]', '$_POST[address]', '$_POST[eircode]', '$dbDate', 
            '$_POST[phoneNumber]', '$_POST[occupation]', '$_POST[salary]', '$_POST[email]', '$_POST[guarantorName]')";

            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Error querying the database" . mysqli_error($con));
                echo "<h2>No record was added to the database</h2>";
            }

            echo "<h2>1 record added to the database</h2>";

            mysqli_close($con);
            ?>
            <form action="./add-customer.html.php" method="post" class="close-window">
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
        document.querySelector("#add-customer-form").classList.add("disabled");
    </script>
</body>

</html>