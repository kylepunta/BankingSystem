<?php
header('Content-Type: application/json');

include './db.inc.php';

if (mysqli_connect_errno()) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

$totals = [];

$totals['Customer'] = (int)$con->query("SELECT COUNT(*) AS c FROM `Customer` WHERE deletedFlag=0")->fetch_assoc()['c'];

$totals['DepositAccount'] = (int)$con->query("SELECT COUNT(*) AS c FROM `Deposit Account` WHERE deletedFlag=0")->fetch_assoc()['c'];

$totals['CurrentAccount'] = (int)$con->query("SELECT COUNT(*) AS c FROM `Current Account` WHERE deletedFlag=0")->fetch_assoc()['c'];

$totals['LoanAccount'] = (int)$con->query("SELECT COUNT(*) AS c FROM `Loan Account` WHERE deletedFlag=0")->fetch_assoc()['c'];


echo json_encode($totals);
