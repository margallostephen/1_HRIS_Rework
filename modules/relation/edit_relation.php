<?php
header('Content-Type: application/json;');

require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'getIPAddress.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';

$rid = $_POST['RID'];
$ir_number = trim($_POST['ir_number']);
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

$sql = "UPDATE `1_relation_masterlist_tb` SET IR_NUMBER = ?, EMPLOYEE_ID = ?, INCIDENT_DATE = ?, VIOLATION = ?, `ACTION` = ?, REASON = ?, UPDATED_BY = ?, UPDATED_IP = ?, UPDATED_AT = NOW() WHERE RID = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssssssssi", $ir_number, $employee, $incident_date, $violation, $action, $reason, $rfid, $ip, $rid);

$result = $stmt->execute() ?
    [
        'status' => true,
        'message' => 'Relation updated successfully.'
    ] : [
        'status' => false,
        'message' => 'Failed to update relation.'
    ];

$stmt->close();
$mysqli->close();
echo json_encode($result);
exit;
