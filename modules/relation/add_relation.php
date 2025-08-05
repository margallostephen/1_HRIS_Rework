<?php
header('Content-Type: application/json;');

require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'getIPAddress.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';

$ir_number = $_POST['ir_number'];
$employee = $_POST['employee'];
$incident_date = $_POST['incident_date'];
$violation = $_POST['violation'];
$action = $_POST['action'];
$reason = trim($_POST['reason']);
$rfid = $_SESSION['RFID'];
$ip = getUserIP();

if (
    empty($ir_number) || empty($employee) || empty($incident_date) ||
    empty($violation) || empty($action) || empty($reason)
) {
    echo json_encode([
        'status' => false,
        'message' => 'All fields are required.'
    ]);
    exit;
}

$stmt = $mysqli->prepare("SELECT 1 FROM `1_relation_masterlist_tb` WHERE IR_NUMBER = ? LIMIT 1");
$stmt->bind_param("s", $ir_number);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode([
        'status' => false,
        'message' => 'IR Number already exists.'
    ]);
    $stmt->close();
    exit;
}

$stmt->close();

$sql = "INSERT INTO `1_relation_masterlist_tb` (IR_NUMBER, EMPLOYEE_ID, INCIDENT_DATE, VIOLATION, `ACTION`, REASON, CREATED_BY, CREATED_IP) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode([
        'status' => false,
        'message' => 'Failed to prepare statement: ' . $mysqli->error
    ]);
    exit;
}

$stmt->bind_param("sssiisss", $ir_number, $employee, $incident_date, $violation, $action, $reason, $rfid, $ip);

$result = $stmt->execute() ?
    [
        'status' => true,
        'message' => 'Relation added successfully.'
    ] : [
        'status' => false,
        'message' => 'Failed to add relation.'
    ];

$stmt->close();
$mysqli->close();

echo json_encode($result);
exit;
