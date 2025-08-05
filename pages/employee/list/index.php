<!DOCTYPE html>
<html lang="en">
<?php require_once PARTIALS_PATH . '/header.php'; ?>

<body class="no-skin">
    <?php require_once PARTIALS_PATH . '/navbar.php'; ?>
    <div class="main-container ace-save-state" id="main-container">
        <?php require_once PARTIALS_PATH . '/sidebar.php'; ?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Employee List</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <div class="header-title">
                                        List of Employees
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="p-4">
                                            <div class="table-btn-container">
                                                <?php
                                                require_once PAGES_PATH . '/employee/list/modals/addModal.php';
                                                require_once PAGES_PATH . '/employee/list/modals/editModal.php';
                                                require_once PAGES_PATH . '/excel/modals/importModal.php';
                                                ?>
                                                <div class="side-btn-container">
                                                    <div class="excel-btn-container">
                                                        <button class="btn btn-md btn-white" id="generateExcelTemplateBtn">
                                                            Generate Template</button>
                                                        <button class="btn btn-md btn-inverse" id="importExcelBtn">
                                                            Import to Table</button>
                                                        <button class="btn btn-md btn-success" id="exportExcelBtn">
                                                            Export to Excel</button>
                                                    </div>
                                                    <button class="btn btn-md btn-warning" id="clearAllFilterBtn" disabled>Clear Filter</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div id="loader" class="loader-container">
                                                <div class="spinner"></div>
                                                <strong id="loadingText">Loading</strong>
                                            </div>
                                            <div id="employee-table" hidden></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once PARTIALS_PATH . '/footer.php'; ?>
    </div>

    <script type="text/javascript" src="<?php getAjaxPath('excel/importExcel.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('excel/exportExcel.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('excel/generateTemplate.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('employee_relation/deleteRelation.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSUtil('mapData.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSUtil('computeAge.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSUtil('formatAddress.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSUtil('calculateEvaluation.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSUtil('calculateYearsOfService.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('createTable.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('resetModal.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('resetLoader.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('clearFilter.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('populateTable.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('errorFunction.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('dateRangePicker.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('tableColumnFreeze.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSFile('scrollSpy.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSFile('inputmask.min.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSFile('daterangepicker.min.js') ?>"></script>
    <script type="text/javascript">
        let employeeTable;

        Promise.all([
            setList("barangay", "address/get_barangay"),
            setList("province", "address/get_province"),
            setList("municipality", "address/get_municipality"),
            setList("suffix", "suffix/get_suffix"),
            setList("company", "company/get_company"),
            setList("employee", "employee/get_employee"),
            setList("job_title", "job_title/get_job_title"),
            setList("department", "department/get_department"),
            setList("civil_status", "civil_status/get_civil_status"),
            setList("educ_attainment", "educ_attainment/get_educ_attainment"),
            setList("employment_status", "employment_status/get_employment_status"),
        ]).then(function() {
            const freeze = window.innerWidth > 728;
            employeeTable = createTable("employee",
                'EMPLOYEE_ID',
                [{
                        title: "No.",
                        field: "ROW_INDEX",
                        headerFilter: "input",
                        vertAlign: "middle",
                        frozen: freeze
                    },
                    {
                        title: "RFID",
                        field: "RFID",
                        headerFilter: "input",
                        vertAlign: "middle",
                        frozen: freeze
                    }, {
                        title: "EMPLOYEE NAME",
                        field: "EMPLOYEE_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "FIRST NAME",
                        field: "F_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "MIDDLE NAME",
                        field: "M_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "LAST NAME",
                        field: "L_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "SUFFIX",
                        field: "SUFFIX",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "BIRTH DATE",
                        field: "BIRTH_DATE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "AGE",
                        field: "AGE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "BIRTH PLACE",
                        field: "BIRTH_PLACE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "EMAIL",
                        field: "EMAIL",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CONTACT NUMBER",
                        field: "CONTACT_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "GENDER",
                        field: "GENDER",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle",
                        headerFilterFunc: "="
                    }, {
                        title: "CIVIL STATUS",
                        field: "CIVIL_STATUS",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "DEPARTMENT CODE",
                        field: "DEPARTMENT_CODE",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "DEPARTMENT NAME",
                        field: "DEPARTMENT_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "JOB TITLE",
                        field: "JOB_TITLE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "COMPANY CODE",
                        field: "COMPANY_CODE",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle",
                        frozen: freeze
                    }, {
                        title: "COMPANY NAME",
                        field: "COMPANY_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CATEGORY",
                        field: "CATEGORY",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT PROVINCE",
                        field: "CURR_ADDR_PROVINCE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT MUNICIPALITY",
                        field: "CURR_ADDR_MUNICIPALITY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT BARANGAY",
                        field: "CURR_ADDR_BARANGAY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT STREET",
                        field: "CURR_ADDR_STREET",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT ZIP CODE",
                        field: "CURR_ADDR_ZIP_CODE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CURRENT FULL ADDRESS",
                        field: "CURRENT_FULL_ADDRESS",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT PROVINCE",
                        field: "PERM_ADDR_PROVINCE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT MUNICIPALITY",
                        field: "PERM_ADDR_MUNICIPALITY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT BARANGAY",
                        field: "PERM_ADDR_BARANGAY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT STREET",
                        field: "PERM_ADDR_STREET",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT ZIP CODE",
                        field: "PERM_ADDR_ZIP_CODE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PERMANENT FULL ADDRESS",
                        field: "PERMANENT_FULL_ADDRESS",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "EMERGENCY CONTACT PERSON",
                        field: "CONTACT_PERSON",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "RELATIONSHIP",
                        field: "CONTACT_RELATION",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "CONTACT PERSON NUMBER",
                        field: "CONTACT_PERSON_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "SSS NUMBER",
                        field: "SSS_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PAGIBIG NUMBER",
                        field: "PAGIBIG_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PILHEALTH NUMBER",
                        field: "PHILHEALTH_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "TIN NUMBER",
                        field: "TIN_NO",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "EDUCATIONAL ATTAINMENT",
                        field: "EDUC_ATTAINMENT",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle",
                        headerFilterFunc: "="
                    }, {
                        title: "COURSE",
                        field: "COURSE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "LAST SCHOOL ATTENDED",
                        field: "LAST_SCHOOL",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PREVIOUS JOB",
                        field: "PREV_JOB",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "PREVIOUS COMPANY",
                        field: "PREV_COMPANY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "STATUS",
                        field: "STATUS",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "SERVICE",
                        field: "SERVICE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "DATE HIRED",
                        field: "DATE_HIRED",
                        sorter: "DATE_HIRED",
                        headerFilter: "input",
                        headerFilterPlaceholder: "YYYY-MM-DD to YYYY-MM-DD",
                        headerFilterFunc: (value, rowValue) => setDateRangeFilter(value, rowValue),
                        vertAlign: "middle",
                        minWidth: 245,
                    }, {
                        title: "EVALUATION (3 MONTHS)",
                        field: "EVALUATION_3_MONTHS",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "EVALUATION (5 MONTHS)",
                        field: "EVALUATION_5_MONTHS",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "END OF PROBATIONARY",
                        field: "END_OF_PROBATIONARY",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "START OF REGULARIZATION",
                        field: "START_OF_REGULARIZATION",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "DATE SEPARATED",
                        field: "DATE_SEPARATED",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "DATE REGISTERED",
                        field: "CREATED_AT",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "DATE LAST UPDATED",
                        field: "UPDATED_AT",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "USER",
                        field: "USER",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "ACTIVE",
                        field: "ACTIVE",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle",
                        frozen: freeze,
                        headerFilterFunc: "="
                    }, {
                        title: "BIO USER ID",
                        field: "BIO_USER_ID",
                        headerFilter: "input",
                        vertAlign: "middle"
                    },
                ],
                getList("relation"),
                "fitData"
            );

            populateTable(`employee/get_employee`, employeeTable, {
                delete_status: 0
            });

            addClearFilter(employeeTable, "DATE_HIRED");
            addDateRangePicker(employeeTable, ["DATE_HIRED"]);

            $("#generateExcelTemplateBtn").on("click", () =>
                Swal.fire({
                    title: "Generate Template",
                    text: "Are you adding a new or resign employees?",
                    icon: "info",
                    iconColor: "#3498DB",
                    showDenyButton: true,
                    confirmButtonColor: "#87B87F",
                    denyButtonColor: "#D15B47",
                    confirmButtonText: "New Employees",
                    denyButtonText: "Resigned Employees",
                }).then((result) => {
                    if (!result.isDismissed) {
                        let column = [
                            'EMPLOYEE ID', 'FIRST NAME', 'MIDDLE NAME', 'LAST NAME', 'SUFFIX',
                            'BIRTH DATE', 'BIRTH PLACE', 'EMAIL', 'CONTACT NO', 'GENDER',
                            'CIVIL STATUS', 'DEPARTMENT', 'JOB TITLE', 'COMPANY', 'CATEGORY',
                            'CURRENT PROVINCE', 'CURRENT MUNICIPALITY', 'CURRENT BARANGAY',
                            'CURRENT STREET', 'CURRENT ZIP CODE',
                            'PERMANENT PROVINCE', 'PERMANENT MUNICIPALITY', 'PERMANENT BARANGAY',
                            'PERMANENT STREET', 'PERMANENT ZIP CODE',
                            'CONTACT PERSON', 'CONTACT RELATION', 'CONTACT PERSON NO',
                            'SSS NO', 'PAGIBIG NO', 'PILHEALTH NO', 'TIN NO',
                            'EDUCATIONAL ATTAINMENT', 'COURSE', 'LAST SCHOOL',
                            'PREVIOUS JOB', 'PREVIOUS COMPANY', 'DATE HIRED', 'BIO USER ID'
                        ];

                        let templateType = "new";

                        if (result.isDenied) {
                            column.splice(column.indexOf('PREVIOUS JOB') + 1, 0, 'STATUS');
                            column.splice(column.indexOf('DATE HIRED') + 1, 0, 'LAST DATE');
                            templateType = "resigned";
                        }

                        generateTemplate(column, `${templateType}_employee`, employeeTable);
                    }
                })
            );

            $("#importExcelForm").on("submit", (e) => {
                e.preventDefault();

                const actionMap = mapData(getList("action"), 'ACTION_DESCRIPTION');
                const violationMap = mapData(getList("violation"), 'VIOLATION_DESCRIPTION');

                const cleanedData = jsonData.map((emp) => {
                    const violationDescription = emp.VIOLATION;
                    const actionDescription = emp.ACTION;
                    const violationId = violationMap[violationDescription]?.RID;
                    const actionId = actionMap[actionDescription]?.RID;

                    return {
                        ...emp,
                        VIOLATION: violationId ? parseInt(violationId, 10) : violationDescription,
                        ACTION: actionId ? parseInt(actionId, 10) : actionDescription
                    };
                });

                importExcel('relation', employeeTable, cleanedData, `relation/get_relation`, {
                    delete_status: 0
                });

                jsonData = [];
            });

            // $("#exportExcelBtn").on("click", () => exportExcel(employeeTable,
            //     [
            //         "IR_NUMBER",
            //         "COMPANY",
            //         "EMPLOYEE_ID",
            //         "EMPLOYEE_NAME",
            //         "VIOLATION",
            //         "INCIDENT_DATE",
            //         "ACTION",
            //         "REASON"
            //     ], "employee_relation_export"
            // ));

            handleResponsiveColumnFreeze(employeeTable, ["ROW_INDEX", "RFID", "COMPANY_CODE", "ACTIVE"], "EMPLOYEE_ID");

            Inputmask({
                mask: "0999-999-9999",
                placeholder: "",
                autoUnmask: false
            }).mask("#contactNumber, #editContactNumber, #emergencyContactNumber, #editEmergencyContactNumber");
        });
    </script>
</body>

</html>