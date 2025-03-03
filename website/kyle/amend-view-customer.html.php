<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/commonStyles.css">
    <link rel="stylesheet" href="./customer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
            <div class="customer-info">
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
            </div>
        </form>
    </main>
    <script src="./amendView.js"></script>
</body>

</html>