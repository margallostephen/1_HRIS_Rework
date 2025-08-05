<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';

$routes = require_once CONFIG_PATH . 'routes.php';
// $allowedRoles = $routes['allowed_roles'];

$id = $_POST['id'];
$password = $_POST['password'];
$response = ['status' => false, 'message' => ''];

if (empty($id) || empty($password)) {
    $response['message'] = 'ID and password are required.';
    echo json_encode($response);
    exit;
}

$sql = "SELECT e.*, r.ROLE_NAME FROM `1_employee_masterlist_tb` e JOIN `role_tb` r ON e.ROLE = r.ROLE_ID WHERE e.RFID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $response['message'] = 'User not found.';
    echo json_encode($response);
    exit;
}

$user = $result->fetch_assoc();

if ($user['ACTIVE'] != 1 && !in_array($user['RFID'], ["ADMIN", 101,])) {
    $response['message'] = 'Account disabled. Contact administrator.';
    echo json_encode($response);
    exit;
}

if (!password_verify($password, $user['PASSWORD'])) {
    $response['message'] = 'Incorrect password.';
    echo json_encode($response);
    exit;
}

// if (!in_array($user['ROLE'], $allowedRoles)) {
//     $response['message'] = 'You dont have access to this system.';
//     echo json_encode($response);
//     exit;
// }

session_start();

$_SESSION = [
    'RFID' => $user['RFID'],
    'FIRST_NAME' => $user['F_NAME'],
    'LAST_NAME' => $user['L_NAME'],
    'EMAIL' => $user['EMAIL'],
    'ROLE' => $user['ROLE'],
    'ROLE_NAME' => $user['ROLE_NAME'],
    'LAST_ACTIVITY' => time(),
];

unset($user['PASSWORD']);
$response = ['status' => true, 'message' => 'Logging in.', 'user' => $user];

$stmt->close();
$mysqli->close();

echo json_encode($response);
