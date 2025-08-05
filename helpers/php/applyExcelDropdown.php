<?php

use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

function applyExcelDropdown($spreadsheet, $sheet, $mainCon, $addressCon,  $table, $headers, $rowCountToGenerate)
{
    switch ($table) {
        case 'relation-table':
            $dropdownLists = [
                'VIOLATION' => [
                    'source' => 'table',
                    'column' => 'VIOLATION_DESCRIPTION',
                    'table'  => 'violation_tb'
                ],
                'ACTION' => [
                    'source' => 'table',
                    'column' => 'ACTION_DESCRIPTION',
                    'table'  => 'action_tb'
                ]
            ];

            break;
        case 'employee-table':
            $dropdownLists = [
                'SUFFIX' => [
                    'source' => 'table',
                    'column' => 'SUFFIX',
                    'table'  => 'suffix_tb'
                ],
                'GENDER' => [
                    'source' => 'static',
                    'values' => ['MALE', 'FEMALE']
                ],
                'CIVIL_STATUS' => [
                    'source' => 'table',
                    'column' => 'CIVIL_STATUS',
                    'table'  => 'civil_status_tb'
                ],
                'DEPARTMENT' => [
                    'source' => 'table',
                    'column' => 'DEPARTMENT_NAME',
                    'table'  => 'department_tb'
                ],
                'JOB_TITLE' => [
                    'source' => 'table',
                    'column' => 'JOB_TITLE',
                    'table'  => 'job_position_tb'
                ],
                'COMPANY' => [
                    'source' => 'table',
                    'column' => 'COMPANY_NAME',
                    'table'  => 'company_tb'
                ],
                'CATEGORY' => [
                    'source' => 'static',
                    'values' => ['DIRECT', 'INDIRECT']
                ],
                'EDUCATIONAL_ATTAINMENT' => [
                    'source' => 'table',
                    'column' => 'EDUC_ATTAINMENT',
                    'table'  => 'educ_attainment_tb'
                ],
                'STATUS' => [
                    'source' => 'table',
                    'column' => 'EMPLOYMENT_STATUS',
                    'table'  => 'employment_status_tb'
                ],
                'CURRENT_PROVINCE' => [
                    'source' => 'other_db',
                    'column' => 'provDesc',
                    'table'  => 'refprovince'
                ],
                'CURRENT_MUNICIPALITY' => [
                    'source' => 'other_db',
                    'column' => 'citymunDesc',
                    'table'  => 'refcitymun'
                ],
                'CURRENT_BARANGAY' => [
                    'source' => 'other_db',
                    'column' => 'brgyDesc',
                    'table'  => 'refbrgy'
                ],
                'PERMANENT_PROVINCE' => [
                    'source' => 'other_db',
                    'column' => 'provDesc',
                    'table'  => 'refprovince'
                ],
                'PERMANENT_MUNICIPALITY' => [
                    'source' => 'other_db',
                    'column' => 'citymunDesc',
                    'table'  => 'refcitymun'
                ],
                'PERMANENT_BARANGAY' => [
                    'source' => 'other_db',
                    'column' => 'brgyDesc',
                    'table'  => 'refbrgy'
                ],
            ];
            break;
        default:
            $dropdownLists = [];
    }

    $hiddenSheet = new Worksheet($spreadsheet, 'dropdowns');
    $spreadsheet->addSheet($hiddenSheet)->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

    $colOffset = 1;

    foreach ($dropdownLists as $columnHeader => $config) {
        if ($config['source'] === 'static') {
            $options = $config['values'];
        } else if ($config['source'] === 'table') {
            $result = mysqli_query($mainCon, "SELECT DISTINCT {$config['column']} FROM {$config['table']} WHERE DELETED_STATUS = 0");
            $field = mysqli_fetch_fields($result);
            $columnToFetch = $field[0]->name;
            $options = $result ? array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), $columnToFetch) : [];
        } else {
            $result = mysqli_query($addressCon, "SELECT DISTINCT {$config['column']} FROM {$config['table']} ORDER BY {$config['column']} ASC");
            $field = mysqli_fetch_fields($result);
            $columnToFetch = $field[0]->name;
            $options = $result ? array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), $columnToFetch) : [];
        }

        $colIndex = array_search(str_replace('_', ' ', $columnHeader), $headers);

        if (!empty($options) && $colIndex !== false) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
            $hiddenCol = Coordinate::stringFromColumnIndex($colOffset);

            foreach ($options as $i => $value) {
                $hiddenSheet->setCellValue("{$hiddenCol}" . ($i + 1), trim($value));
            }

            $rangeName = "{$columnHeader}_list";
            $rangeDef = "'dropdowns'!\${$hiddenCol}\$1:\${$hiddenCol}\$" . count($options);
            $spreadsheet->addNamedRange(new NamedRange($rangeName, $hiddenSheet, $rangeDef));

            for ($row = 2; $row <= $rowCountToGenerate; $row++) {
                $cell = $colLetter . $row;
                $validation = $sheet->getCell($cell)->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST)
                    ->setShowDropDown(true)
                    ->setFormula1("={$rangeName}");
            }

            $colOffset++;
        }
    }
}
