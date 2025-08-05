<?php
function dataExist($mysqli, $table, $column, $value)
{
    $type = is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
    $stmt = $mysqli->prepare("SELECT 1 FROM `$table` WHERE `$column` = ? LIMIT 1");
    $stmt->bind_param($type, $value);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}
