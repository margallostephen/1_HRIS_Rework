<?php
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'getIPAddress.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';

$response = ['status' => false, 'message' => ''];

if (empty($_POST['relation_id'])) {
    $response['message'] = 'Relation ID is missing!';
} else {

    $rfid = $_SESSION['RFID'];
    $ip = getUserIP();
    $relation_id = $_POST['relation_id'];

    $sql = "UPDATE `1_relation_masterlist_tb` SET DELETED_AT = NOW(), DELETED_BY = ?, DELETED_IP = ?, DELETED_STATUS = 1 WHERE RID = ? AND DELETED_STATUS = 0";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $rfid, $ip, $relation_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            'status' => true,
            'message' => 'Relation deleted successfully.'
        ];
    } else {
        $response['message'] = 'Relation not found or already deleted.';
    }

    $stmt->close();
}

$mysqli->close();
echo json_encode($response);
