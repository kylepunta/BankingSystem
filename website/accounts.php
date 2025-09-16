<?php
// api/account_types.php
header('Content-Type: application/json');
require_once __DIR__ . '/db.inc.php';

if (mysqli_connect_errno()) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

$sql = "SELECT account_type, COUNT(*) AS cnt FROM accounts GROUP BY account_type ORDER BY account_type";
$res = $conn->query($sql);

$labels = $data = [];
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $labels[] = $r['account_type'];
        $data[]   = (int)$r['cnt'];
    }
}

echo json_encode(['labels' => $labels, 'data' => $data]);
