<!--
Name: Oliwier Jakubiec
Date: 13/2/2025
ID : C00296807
Title: display view php
	-->
    <?php
// start session
session_start();
include 'db.inc.php';      // include DB access file

// prepare sql statement
$sql = "SELECT customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo 
        FROM Customer WHERE deletedFlag = '0' AND customerNo = ". $_POST['custID'];

// check if any errors occurred in the query
if (!$result = mysqli_query($con,$sql)) {
    die ('Error in querying the database' . mysqli_error($con));
}

// get the number of rows
$rowcount = mysqli_affected_rows($con);

// set session 'personid' as personid from the Post
$_SESSION['customerID']=$_POST['custID'];

// if theres one rowcount then a record has been found
if ($rowcount == 1) {
    // fetch associative array from the query
    $row = mysqli_fetch_array($result);

    // set all session variables as the fetched values from the table
    $_SESSION['customerID']=$row['customerNo']; 
    $_SESSION['name']=$row['firstName'];
    $_SESSION['address']=$row['address'];
    $_SESSION['eircode']=$row['eircode']; 
    $_SESSION['dob']=$row['dateOfBirth'];
    $_SESSION['phone']=$row['telephoneNo'];

}
else if ($rowcount == 0) {  // if no record found unset all session variables
    unset ($_SESSION['name']); 
    unset ($_SESSION['dob']);
    unset ($_SESSION['address']);
    unset ($_SESSION['eircode']);
    unset ($_SESSION['dob']);
    unset ($_SESSION['phone']);

}

$run = true;
$keepRunning = true;
while ($run) {

    $random = rand(10000000,99999999);

    $sql = "SELECT accountNumber FROM `Deposit Account` UNION 
            SELECT accountNumber FROM `Loan Account` UNION 
            SELECT accountNumber FROM `Current Account`";

    // check if any errors occurred in the query
    if (!$result = mysqli_query($con,$sql)) {
        die ('Error in querying the database' . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {

        if ($random == $row['accountNumber']) {
            $keepRunning = true;
        }
        else {
            $keepRunning = false;
        }
    }

    if ($keepRunning == false) {
        $run = false;
        $_SESSION['accountNumber'] = $random;
    }

}
// close connection
mysqli_close($con);
//Go back to the calling form with the values that we need to display in session variables, if a record was found 
header('Location: index.php' );
// or alternatively use the following
//echo "<script>window.location.href='view.html.php'</script>"; 
?>