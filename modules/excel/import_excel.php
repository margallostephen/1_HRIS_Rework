<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'getIPAddress.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';
require_once PHP_UTILS_PATH . 'getColumnInfo.php';
require_once PHP_UTILS_PATH . 'isValidValue.php';
require_once PHP_HELPERS_PATH . 'checkDataExist.php';

$input = json_decode(file_get_contents("php://input"), true);
$rfid = $_SESSION['RFID'];
$ip = getUserIP();
$tableKey = $input['table'];

if (
    !isset($tableKey) ||
    !is_string($tableKey) ||
    !isset($input['data']) ||
    !is_array($input['data'])
) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid or missing data or table."
    ]);
    exit;
}

$tableMap = [
    'relation' => '1_relation_masterlist_tb'
];

$table = $tableMap[$tableKey] ?? null;

if (!$table || empty($input['data'])) {
    echo json_encode([
        "status" => false,
        "message" => "No data to insert or invalid table name."
    ]);
    exit;
}

$data = array_map(function ($row) {
    $trimmedRow = array_map('trim', $row);

    $updatedRow = [];
    foreach ($trimmedRow as $key => $value) {
        $newKey = strtr($key, [' ' => '_']);
        $updatedRow[$newKey] = $value;
    }

    return $updatedRow;
}, $input['data']);

$columns = array_keys($data[0]);
$columns[] = 'CREATED_BY';
$columns[] = 'CREATED_IP';

$columnList = implode(', ', $columns);
$placeholders = implode(', ', array_fill(0, count($columns), '?'));

$stmt = $mysqli->prepare("INSERT INTO `$table` ($columnList) VALUES ($placeholders)");

if (!$stmt) {
    echo json_encode([
        "status" => false,
        "message" => "The provided data does not match the expected table structure."
    ]);
    exit;
}

$columns = array_diff($columns, ['CREATED_BY', 'CREATED_IP']);

$failedRows = [];
$errorTypes = [];
$successfulInserts = 0;
$columnInfos = getColumnInfo($mysqli, $table, $columns);

$irNumbers = [];

foreach ($data as $index => $row) {
    if (!array_filter($row, fn($val) => trim($val) !== '')) continue;

    $errorRow = [];
    $valid = true;

    foreach ($columnInfos as $field => $info) {
        if (array_key_exists($field, $row) && (!isValidValue($row[$field], $info['type']) || empty(trim($row[$field])))) {
            $valid = false;
            error_log("Checking field: $field, value: " . print_r($row[$field], true) . ", expected type: " . $info['type']);
            $errorRow[$field] = empty(trim($row[$field])) ? "F8DD4E" : "FCAD36";
        }
    }

    switch ($tableKey) {
        case 'relation':

            if (!empty($row['IR_NUMBER']) && (dataExist($mysqli, '1_relation_masterlist_tb', 'IR_NUMBER', $row['IR_NUMBER']) || in_array($row['IR_NUMBER'], $irNumbers))) {
                $valid = false;
                $errorRow['IR_NUMBER'] = "CF3A34";
                error_log("Duplicate IR Number found: " . $row['IR_NUMBER']);
            }

            if (!empty($row['EMPLOYEE_ID']) && !dataExist($mysqli, '1_employee_masterlist_tb', 'RFID', trim($row['EMPLOYEE_ID']))) {
                $valid = false;
                $errorRow['EMPLOYEE_ID'] = is_numeric($row['EMPLOYEE_ID']) ? "CF3A34" : "FCAD36";
                error_log("EMPLOYEE_ID not found in masterlist: " . $row['EMPLOYEE_ID']);
            }
            break;
    }

    $irNumbers[] = $row['IR_NUMBER'];

    if (!$valid) {
        $failedRows[] = $row;
        $errorTypes[] = $errorRow;
        continue;
    }

    $values = [];

    foreach ($row as $val) {
        if ($val === "N/A" || $val == "") {
            $values[] = null;
        } else {
            $values[] = strtoupper($val);
        }
    }

    $values[] = $rfid;
    $values[] = $ip;

    $types = '';
    foreach ($values as $val) {
        $types .= is_numeric($val) ? 'i' : (is_float($val) ? 'd' : 's');
    }

    $bindNames = [];
    $bindNames[] = $types;
    foreach ($values as $key => $value) {
        $bindNames[] = &$values[$key];
    }

    $stmt->reset();

    call_user_func_array([$stmt, 'bind_param'], $bindNames);

    if ($stmt->execute()) {
        $successfulInserts++;
    } else {
        $failedRows[] = $input['data'][$index];
    }

    unset($bindNames);
}

if (!empty($failedRows)) {
    $failedRows['error_types'] = $errorTypes;
}

$failedRowsCount = count($failedRows) - (count($errorTypes) > 0 ? 1 : 0);

$stmt->close();
$mysqli->close();

echo json_encode([
    "status" => true,
    "success_rows" => $successfulInserts,
    "message" => "Data imported. Success: " . $successfulInserts,
    "failed_rows" => $failedRows,
    "failed_rows_message" => "Row insertion. Failed: "  . $failedRowsCount
]);
