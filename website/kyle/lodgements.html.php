<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lodgements</title>
    <?php require("../head.html") ?>
    <link rel="stylesheet" href="./customer.css" />
</head>

<body>
    <?php require("../sideMenu.html") ?>
    <main>
        <form action="./lodgements.php" method="post" id="lodgements-form">
            <p>
                <label for="select-account">Select an account</label>
                <select name="account-dropdown" id="account-dropdown">
                    <?php require("./lodgementsListbox.php") ?>
                </select>
            </p>
        </form>
    </main>
</body>

</html>