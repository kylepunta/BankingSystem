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
            <h3 class="address-heading">Address</h3>
            <p>
                <label for="addressLine1">Address Line 1</label>
                <input type="text" name="addressLine1" id="addressLine1" required>
            </p>
            <p>
                <label for="addressLine2">Address Line 2</label>
                <input type="text" name="addressLine2" id="addressLine2" required>
            </p>
            <p>
                <label for="city">City</label>
                <input type="text" name="city" id="city" required>
            </p>
            <p>
                <label for="country">Country</label>
                <input type="text" name="country" id="country" required>
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
    </main>
</body>

</html>