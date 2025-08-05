<?php

function getColumnInfo(mysqli $mysqli, string $table, array $columns): array
{
    $placeholders = implode(', ', array_map(fn($col) => "'$col'", $columns));

    $sql = "
        SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '$table'
        AND COLUMN_NAME IN ($placeholders)
    ";

    $result = $mysqli->query($sql);
    $columnTypes = [];

    while ($row = $result->fetch_assoc()) {
        $dataType = match (strtolower($row['DATA_TYPE'])) {
            'int', 'bigint', 'tinyint', 'smallint', 'mediumint' => 'int',
            'decimal', 'float', 'double'                        => 'float',
            'date', 'datetime', 'timestamp'                     => 'date',
            default                                             => 'string',
        };

        $columnTypes[$row['COLUMN_NAME']] = [
            'type'     => $dataType,
            'nullable' => strtoupper($row['IS_NULLABLE']) === 'YES',
        ];
    }

    return $columnTypes;
}
