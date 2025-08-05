<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;

require_once '../../vendor/autoload.php';
require_once __DIR__ . '/../../config/serverPath.php';
require_once CONFIG_PATH . 'db.php';
require_once PHP_UTILS_PATH . 'isValidPostRequest.php';
require_once PHP_HELPERS_PATH . 'sessionChecker.php';
require_once PHP_HELPERS_PATH . 'applyExcelDropdown.php';

$input = json_decode(file_get_contents("php://input"), true);
$headers = $input['headers'];
$table = $input['table'];
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$colIndex = 1;
foreach ($headers as $header) {
    $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
    $sheet->setCellValue($cell, $header);
    $colIndex++;
}

$lastCol = Coordinate::stringFromColumnIndex(count($headers));
$rowCountToGenerate = 1000;

$headerRange = "A1:{$lastCol}1";
$sheet->getStyle($headerRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12,
        'name' => 'Tahoma',
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'D9E1F2'
        ]
    ]
]);

$sheet->getRowDimension(1)->setRowHeight(25);

$dataRange = "A2:{$lastCol}$rowCountToGenerate";
$sheet->getStyle($dataRange)->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

for ($i = 1; $i <= count($headers); $i++) {
    $colLetter = Coordinate::stringFromColumnIndex($i);
    $sheet->getColumnDimension($colLetter)->setWidth(40);
}

applyExcelDropdown($spreadsheet, $sheet, $mysqli, $mysqliAddress, $table, $headers, $rowCountToGenerate);
$sheet->freezePane('A2');
$sheet->setSelectedCell('A2');
$sheet->getSheetView()->setZoomScale(85);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
