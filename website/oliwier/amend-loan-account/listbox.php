<?php
include 'db.inc.php';
date_default_timezone_set("UTC");

$sql = "SELECT Customer.customerNo, firstName, surName, address, eircode, dateOfBirth, 
        telephoneNo, `Loan Account`.`accountNumber`, `Loan Account`.accountID, `Loan Account`.balance, 
        `Loan Account`.`loanMonthlyRepayments`, `Loan Account`.`loanTerm`, `Loan Account`.`loanAmount` FROM 
        (`Customer` INNER JOIN `Customer/LoanAccount` ON Customer.customerNo = `Customer/LoanAccount`.`customerNo`) 
        INNER JOIN `Loan Account` ON `Loan Account`.`accountID` = `Customer/LoanAccount`.`accountID`  
        WHERE Customer.deletedFlag = 0 AND `Loan Account`.`deletedFlag` = 0;";

if (!$result = mysqli_query($con, $sql)) {
    die("Error in querying the database " . mysqli_error($con));
}

$selectedCust = $_SESSION['customerID'] ?? '';
$selectedAcc = $_SESSION['closeAccountNumber'] ?? '';

echo "<option value='placeholder'>Select a customer</option>";

while ($row = mysqli_fetch_array($result)) {
    $id = $row["customerNo"];
    $fname = $row["firstName"];
    $lname = $row["surName"];
    $addr = $row["address"];
    $eircode = $row["eircode"];
    $dob = $row["dateOfBirth"];
    $phone = $row["telephoneNo"];
    $accountNo = $row["accountNumber"];
    $balance = $row["balance"];
    $repayments = $row["loanMonthlyRepayments"];
    $term = $row["loanTerm"];
    $loanAmount = $row["loanAmount"];
    $name = $fname . " " . $lname . " : " . $accountNo;
    $allText = "$id#$addr#$eircode#$dob#$phone#$accountNo#$balance#$repayments#$term#$loanAmount";

    $selected = (($id == $selectedCust) && ($accountNo == $selectedAcc)) ? "selected" : "";
    echo "<option value='$allText' $selected>$name</option>";
}

mysqli_close($con);
