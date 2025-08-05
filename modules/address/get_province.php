<?php
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';

$sql = "SELECT provCode, provDesc FROM refprovince ORDER BY provDesc ASC";
$stmt = $mysqliAddress->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => false,
        'message' => "Database error: " . $mysqliAddress->error
    ]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$response = ($result && $result->num_rows > 0)
    ? [
        'status' => true,
        'data' => $result->fetch_all(MYSQLI_ASSOC)
    ] : [
        'status' => false,
        'message' => "No actions found."
    ];

$stmt->close();
$mysqliAddress->close();
echo json_encode($response);
