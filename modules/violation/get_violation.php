<?php
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';

if (!isset($_POST['isSanction'])) {
    require_once PHP_HELPERS_PATH . 'sessionChecker.php';
}

$where = "";
$params = [];
$types = "";
$orderBy = "DESC";

if (isset($_POST['isSanction']) && $_POST['isSanction'] === "true") {
    if (!isset($_POST['sanction'])) {
        echo json_encode(['status' => false, 'message' => 'No violation found.']);
        exit;
    }
    $where .= "WHERE SANCTION = ?";
    $params[] = $_POST['sanction'];
    $types .= "i";
}

if (isset($_POST['delete_status'])) {
    $where .= $where ? " AND " : "";
    $where .= "WHERE DELETED_STATUS = ?";
    $params[] = $_POST['delete_status'];
    $types .= "i";
}

if (isset($_POST['ascending'])) {
    $orderBy = "ASC";
}

$sql = "SELECT * FROM violation_tb $where ORDER BY CREATED_AT $orderBy";
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
        'message' => "No violations found."
    ];

$stmt->close();
$mysqli->close();

echo json_encode($response);
