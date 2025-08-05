async function exportExcel(table, desiredOrder, downloadName, failedData = []) {
    const submitExportBtn = $("#exportExcelBtn").prop("disabled", true);

    let rowData = failedData.length == 0 ? table?.getData("active").map(row =>
        Object.fromEntries(
            desiredOrder
                .map(key => [key, row[key]])
        )
    ) : failedData;

    const data = {
        row_data: rowData,
        table: table.element.getAttribute("id")
    }

    const response = await fetch(`${MODULES_PATH}/excel/export_excel.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    });

    if (response.headers.get("Content-Type")?.includes("application/json")) {
        const responseJson = await response.json();
        if (!sessionValidityChecker(responseJson, table)) return;

        if (!responseJson.status)
            return showToast("warning", responseJson.message, submitExportBtn);
    }

    const blob = await response.blob();
    const url = URL.createObjectURL(blob);

    Object.assign(document.createElement("a"), {
        href: url,
        download: `${downloadName}.xlsx`
    }).click();

    URL.revokeObjectURL(url);

    if (failedData.length == 0)
        showToast("success", "Excel file exported successfully.", submitExportBtn);
    else
        submitExportBtn.prop("disabled", false);
}