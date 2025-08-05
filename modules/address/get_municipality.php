<?php
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';

$where = "";
$params = [];
$types = "";

if (isset($_POST['provCode'])) {
    $where .= "WHERE provCode = ?";
    $params[] = $_POST['provCode'];
    $types .= "s";
}

$sql = "SELECT citymunCode, citymunDesc FROM refcitymun $where ORDER BY citymunDesc ASC";
$stmt = $mysqliAddress->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => false,
        'message' => "Database error: " . $mysqliAddress->error
    ]);
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
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
