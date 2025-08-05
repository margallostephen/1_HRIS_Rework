<?php
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';

$where = "";
$params = [];
$types = "";
$orderBy = "DESC";

if (isset($_POST['delete_status'])) {
    $where .= "WHERE DELETED_STATUS = ?";
    $params[] = $_POST['delete_status'];
    $types .= "i";
}

if (isset($_POST['ascending'])) {
    $orderBy = "ASC";
}

$sql = "SELECT * FROM civil_status_tb $where ORDER BY CREATED_AT $orderBy";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => false,
        'message' => "Database error: " . $mysqli->error
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
$mysqli->close();
echo json_encode($response);
