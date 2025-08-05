async function generateTemplate(data, downloadName, table) {
    const generateBtn = $("#generateExcelTemplateBtn").prop("disabled", true);

    data = {
        headers: data,
        table: table.element.getAttribute("id")
    }

    const response = await fetch(`${MODULES_PATH}/excel/generate_template.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    });

    if (response.headers.get("Content-Type")?.includes("application/json")) {
        const json = await response.json();
        if (!sessionValidityChecker(json, table)) return;
    }

    const blob = await response.blob();
    const url = URL.createObjectURL(blob);

    Object.assign(document.createElement("a"), {
        href: url,
        download: `${downloadName}_template.xlsx`
    }).click();

    URL.revokeObjectURL(url);
    showToast("success", "Template generated.", generateBtn);
}
