function importExcel(tableKey, table, cleanedData, url, tableData = null) {
    const submitImportBtn = $("#submitImportExcelBtn").prop("disabled", true);

    $.ajax({
        url: `${MODULES_PATH}/excel/import_excel.php`,
        method: "POST",
        data: JSON.stringify({
            table: tableKey,
            data: cleanedData,
        }),
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
            if (!sessionValidityChecker(response, table)) return;

            if (response.status) {
                resetModal("modalImport", "importExcelForm");

                if (response.success_rows) {
                    showToast("success", response.message, submitImportBtn);
                    populateTable(url, table, tableData);
                }

                if (Object.keys(response.failed_rows).length > 0) {
                    showToast("info", response.failed_rows_message, submitImportBtn);

                    const rows = [];
                    for (const key in response.failed_rows) {
                        if (!isNaN(key)) {
                            rows.push(response.failed_rows[key]);
                        }
                    }

                    const processMapping = () => {
                        switch (tableKey) {
                            case "relation":
                                return Promise.all([
                                    mapData(getList("violation")),
                                    mapData(getList("action")),
                                ]).then(([violationMap, actionMap]) => {
                                    return rows.map(row => ({
                                        ...row,
                                        VIOLATION: violationMap[row.VIOLATION]?.VIOLATION_DESCRIPTION || row.VIOLATION,
                                        ACTION: actionMap[row.ACTION]?.ACTION_DESCRIPTION || row.ACTION,
                                    }));
                                });
                        }
                    };

                    processMapping()
                        .then(mappedRows => {
                            const rowsObject = {};
                            for (let i = 0; i < mappedRows.length; i++) {
                                rowsObject[i] = mappedRows[i];
                            }
                            rowsObject.error_types = response.failed_rows.error_types;

                            exportExcel(table, [], `failed_${tableKey}_import`, rowsObject);
                        })
                        .catch(error => {
                            console.error("Failed to process mappings:", error);
                        });
                }
            } else {
                showToast("warning", response.message, submitImportBtn);
            }
        },
        error: (error) => errorFunction(error, submitImportBtn)
    });
}