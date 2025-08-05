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
                        <h1>Employee Relation</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <div class="header-title">
                                        List of Relations
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="p-4">
                                            <div class="table-btn-container">
                                                <?php
                                                require_once PAGES_PATH . '/employee/relation/modals/addModal.php';
                                                require_once PAGES_PATH . '/employee/relation/modals/editModal.php';
                                                require_once PAGES_PATH . '/employee/relation/modals/viewModal.php';
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
                                            <div id="relation-table" hidden></div>
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

    <script type="text/javascript" src="<?php getJSUtil('mapData.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('resetModal.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('createTable.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('resetLoader.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('clearFilter.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('populateTable.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('errorFunction.js') ?>"></script>
    <script type="text/javascript" src="<?php getJSHelper('tableColumnFreeze.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('excel/importExcel.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('excel/exportExcel.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('excel/generateTemplate.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('employee_relation/deleteRelation.js') ?>"></script>

    <script type="text/javascript">
        let relationTable;

        Promise.all([
            setList("action", "action/get_action"),
            setList("company", "company/get_company"),
            setList("employee", "employee/get_employee"),
            setList("violation", "violation/get_violation"),
        ]).then(function() {
            relationTable = createTable("relation",
                'RID',
                [{
                        title: "IR NUMBER",
                        field: "IR_NUMBER",
                        headerFilter: "input",
                        vertAlign: "middle"
                    },
                    {
                        title: "COMPANY",
                        field: "COMPANY",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "EMPLOYEE ID",
                        field: "EMPLOYEE_ID",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "EMPLOYEE NAME",
                        field: "EMPLOYEE_NAME",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "VIOLATION",
                        field: "VIOLATION",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "WHEN",
                        field: "INCIDENT_DATE",
                        headerFilter: "input",
                        vertAlign: "middle"
                    }, {
                        title: "ACTION",
                        field: "ACTION",
                        headerFilter: "list",
                        headerFilterPlaceholder: "Select",
                        headerFilterParams: {
                            valuesLookup: true,
                        },
                        vertAlign: "middle"
                    }, {
                        title: "REASON",
                        field: "REASON",
                        headerSort: false,
                        vertAlign: "middle",
                        tooltip: "Click to view",
                        cellClick: (e, cell) => {
                            $("#viewReason").val(cell.getValue());
                            $("#modalView").modal("show");
                        },
                    },
                ],
                getList("relation"),
            );

            populateTable(`relation/get_relation`, relationTable, {
                delete_status: 0
            });

            addClearFilter(relationTable);

            $("#generateExcelTemplateBtn").on("click", () =>
                generateTemplate([
                        "IR NUMBER",
                        "EMPLOYEE ID",
                        "VIOLATION",
                        "INCIDENT DATE",
                        "ACTION",
                        "REASON"
                    ],
                    "employee_relation",
                    relationTable
                )
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

                importExcel('relation', relationTable, cleanedData, `relation/get_relation`, {
                    delete_status: 0
                });

                jsonData = [];
            });

            $("#exportExcelBtn").on("click", () => exportExcel(relationTable,
                [
                    "IR_NUMBER",
                    "COMPANY",
                    "EMPLOYEE_ID",
                    "EMPLOYEE_NAME",
                    "VIOLATION",
                    "INCIDENT_DATE",
                    "ACTION",
                    "REASON"
                ], "employee_relation_export"
            ));

            handleResponsiveColumnFreeze(relationTable, ["RID"], "RID");
        });
    </script>
</body>

</html>