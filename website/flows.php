<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.inc.php'; // your mysqli $con connection

// count per month for current year
$sql = "
  SELECT 
    MONTH(`date`) AS m,
    SUM(CASE WHEN transactionType IN ('Deposit', 'Lodgement') THEN 1 ELSE 0 END) AS deposits,
    SUM(CASE WHEN transactionType IN ('Withdrawal', 'Withdraw') THEN 1 ELSE 0 END) AS withdrawals
  FROM (
    SELECT transactionType, `date` FROM `Deposit Account History`
    UNION ALL
    SELECT transactionType, `transactionDate` FROM `Loan Account History`
    UNION ALL
    SELECT transactionType, `date` FROM `Current Account History`
  ) all_tx
  WHERE YEAR(`date`) = YEAR(CURDATE())
  GROUP BY MONTH(`date`)
  ORDER BY MONTH(`date`)
";

$res = $con->query($sql);

// Pre-fill Jan–Dec with zeros
$labels = [];
$deps   = [];
$withs  = [];
for ($m = 1; $m <= 12; $m++) {
    $labels[$m] = date('M', mktime(0, 0, 0, $m, 1));
    $deps[$m]   = 0;
    $withs[$m]  = 0;
}

while ($row = $res->fetch_assoc()) {
    $m = (int)$row['m'];
    $deps[$m]  = (int)$row['deposits'];
    $withs[$m] = (int)$row['withdrawals'];
}

echo json_encode([
    'labels'      => array_values($labels),
    'deposits'    => array_values($deps),
    'withdrawals' => array_values($withs),
]);
