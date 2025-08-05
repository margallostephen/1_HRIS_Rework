<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

require_once '../../vendor/autoload.php';
require_once __DIR__ . '/../../config/serverPath.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'getIPAddress.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';
require_once PHP_HELPERS_PATH . 'applyExcelDropdown.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input['row_data'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => false,
        'message' => 'Invalid data format. Expecting a valid JSON object.'
    ]);
    exit;
}

if (empty($input['row_data'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => false,
        'message' => 'No data available to export.'
    ]);
    exit;
}

$lastKey = array_key_last($input['row_data']);

if ($lastKey === "error_types") {
    $row_import_error = $input['row_data'][$lastKey];
    unset($input['row_data'][$lastKey]);
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = array_keys($input['row_data'][0] ?? []);

$formattedHeaders = array_map(function ($header) {
    return ucwords(str_replace('_', ' ', $header));
}, $headers);

$sheet->fromArray($formattedHeaders, null, 'A1');

$row = 2;
foreach ($input['row_data'] as $record) {
    $sheet->fromArray(array_values($record), null, 'A' . $row++);
}

$highestColumn = $sheet->getHighestColumn();
$highestRow = $sheet->getHighestRow();
$dataRange = 'A2:' . $highestColumn . $highestRow;

$sheet->setAutoFilter("A1:$highestColumn" . '1');

$sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'name' => 'Tahoma'],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ]
]);

$sheet->getStyle($dataRange)->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ]
]);

foreach (range('A', $highestColumn) as $colLetter) {
    $maxLength = 0;
    for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
        $cellValue = $sheet->getCell($colLetter . $rowIndex)->getValue();
        $length = strlen($cellValue);
        if ($length > $maxLength) {
            $maxLength = $length;
        }
    }

    if ($maxLength > 100) {
        $sheet->getColumnDimension($colLetter)->setWidth(70);
    } elseif ($maxLength > 50) {
        $sheet->getColumnDimension($colLetter)->setWidth(50);
    } else {
        $sheet->getColumnDimension($colLetter)->setWidth(30);
    }
}

for ($i = 1; $i <= $highestRow; $i++) {
    $sheet->getRowDimension($i)->setRowHeight(-1);
}

if (!empty($row_import_error)) {
    foreach ($row_import_error as $i => $error) {
        foreach ($error as $key => $color) {
            if (($colIdx = array_search($key, $headers)) !== false) {
                $cell = Coordinate::stringFromColumnIndex($colIdx + 1) . ($i + 2);
                $style = $sheet->getStyle($cell);
                $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
                $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        }
    }
}

applyExcelDropdown($spreadsheet, $sheet, $mysqli, $mysqliAddress, $input['table'], $headers, $highestRow);
$sheet->freezePane('A2');
$sheet->setSelectedCell('A' . $highestRow + 1);
$sheet->getSheetView()->setZoomScale(85);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
