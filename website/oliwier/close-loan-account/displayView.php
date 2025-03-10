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
$sql = "SELECT Customer.customerNo, firstName, surName, address, eircode, dateOfBirth, telephoneNo, 
        `Loan Account`.`accountNumber`, `Loan Account`.accountID, `Loan Account`.balance FROM (`Customer` INNER JOIN `Customer/LoanAccount` 
        ON Customer.customerNo = `Customer/LoanAccount`.`customerNo`) INNER JOIN `Loan Account` ON `Loan Account`.`accountID` = 
        `Customer/LoanAccount`.`accountID` WHERE Customer.customerNo = ". $_POST['custID'] . " AND `Loan Account`.`accountNumber` = " . $_POST['closeAccountNumber'] . ";";

// check if any errors occurred in the query
if (!$result = mysqli_query($con,$sql)) {
    die ('Error in querying the database' . mysqli_error($con));
}

// get the number of rows
$rowcount = mysqli_affected_rows($con);

// set session 'personid' as personid from the Post
$_SESSION['customerID']=$_POST['custID'];

// set session 'personid' as personid from the Post
$_SESSION['closeAccountNumber']=$_POST['closeAccountNumber'];

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
    $_SESSION['closeAccountNumber']=$row['accountNumber'];
    $_SESSION['balance']=$row['balance'];
    $_SESSION['accountConfirmed'] = true;
    
}
else if ($rowcount == 0) {  // if no record found unset all session variables
    unset ($_SESSION['name']); 
    unset ($_SESSION['dob']);
    unset ($_SESSION['address']);
    unset ($_SESSION['eircode']);
    unset ($_SESSION['dob']);
    unset ($_SESSION['phone']);
    unset ($_SESSION['balance']);
    unset ($_SESSION['accountConfirmed']);

}


// close connection
mysqli_close($con);
//Go back to the calling form with the values that we need to display in session variables, if a record was found 
header('Location: index.php' );
// or alternatively use the following
//echo "<script>window.location.href='view.html.php'</script>"; 
?>