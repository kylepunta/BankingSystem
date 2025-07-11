<!-- Name: Group work (mostly done by Brandon Jaroszczak and Darian Byrne) -->
<!-- Month: February/March 2025 -->
<!-- Purpose: index page when first logging into https://c2p-bank.candept.com -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETU Bank</title>
    <link rel="stylesheet" href="mainMenu.css">
    <?php require('head.html') ?>
</head>
<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>
    <main>
        <div id="mainmenu">
            <h1>Welcome to SETU Bank</h1>
            <p>A full stack web development project built using frontend and backend technologies such as:</p>
            <ul>
                <li>Frontend: HTML, CSS, JavaScript</li>
                <li>Backend: PHP, MySQL</li>
            </ul>
            <p>Made for the Software Development course in SETU Carlow as part of the Web Development module in 2nd year</p>
            <h3>The authors:</h3>
            <ul>
                <li>Brandon Jaroszczak</li>
                <li>Oliwier Jakubiec</li>
                <li>Darian Byrne</li>
                <li>Kyle Purcell</li>
            </ul>
            <br>
            <form action="resetDB.php" method="post" onsubmit="return confirm('Are you sure you wish to reset the database? All changes made will be lost!')">
            <div class="buttons">
                <!-- Submit button to confirm customer details to continue -->
                <input type="submit" value="Reset Database" id="confirmCustomerButton" name="confirmDetails">
            </div>
            </form>
        </div>
    </main>
</body>
</html>