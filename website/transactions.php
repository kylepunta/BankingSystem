<?php
header('Content-Type: application/json');
ini_set('display_errors', 1); // remove in prod
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    require_once __DIR__ . '/db.inc.php'; // make sure this defines $con (mysqli)
    if (!isset($con) || !($con instanceof mysqli)) {
        throw new RuntimeException('No mysqli $con connection found.');
    }

    // We normalize different column names into the same aliases:
    // tx_date, customer, account_no, type, amount
    $sql = "
    SELECT tx_date, customer, account_no, type, amount
FROM (
  -- Deposit Account History -> Customer/Deposit Account -> Customer
  SELECT 
    DATE(DAH.`date`) AS tx_date,
    CONCAT(C.`firstName`, ' ', C.`surName`) AS customer,
    DAH.`accountId` AS account_no,
    DAH.`transactionType` AS type,
    DAH.`transactionAmount` AS amount
  FROM `Deposit Account History` DAH
  JOIN `Customer/Deposit Account` CDA
    ON CDA.`accountId` = DAH.`accountId`
  JOIN `Customer` C
    ON C.`customerNo` = CDA.`customerNo`

  UNION ALL

  -- Current Account History -> Customer/CurrentAccount -> Customer
  SELECT 
    DATE(CAH.`date`) AS tx_date,
    CONCAT(C.`firstName`, ' ', C.`surName`) AS customer,
    CAH.`accountId` AS account_no,
    CAH.`transactionType` AS type,
    CAH.`amount` AS amount
  FROM `Current Account History` CAH
  JOIN `Customer/CurrentAccount` CCA
    ON CCA.`accountId` = CAH.`accountId`
  JOIN `Customer` C
    ON C.`customerNo` = CCA.`customerNo`

  UNION ALL

  -- Loan Account History -> Customer/LoanAccount -> Customer
  SELECT 
    DATE(LAH.`transactionDate`) AS tx_date,
    CONCAT(C.`firstName`, ' ', C.`surName`) AS customer,
    LAH.`accountID` AS account_no,
    LAH.`transactionType` AS type,
    LAH.`repaymentAmount` AS amount
  FROM `Loan Account History` LAH
  JOIN `Customer/LoanAccount` CLA
    ON CLA.`accountID` = LAH.`accountID`
  JOIN `Customer` C
    ON C.`customerNo` = CLA.`customerNo`
) t
ORDER BY tx_date DESC
LIMIT 3;

  ";

    $res = $con->query($sql);

    $rows = [];
    while ($r = $res->fetch_assoc()) {
        $rows[] = [
            'tx_date'    => $r['tx_date'],
            'customer'   => $r['customer'],
            'account_no' => $r['account_no'],
            'type'       => $r['type'],
            'amount'     => (float)$r['amount'],
        ];
    }

    echo json_encode($rows);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error', 'detail' => $e->getMessage()]);
}
