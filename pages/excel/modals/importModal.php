<div id="modalImport" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Data to Table</h4>
            </div>
            <form id="importExcelForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="excelFileImport">Select File</label>
                        <input type="file" class="form-control" id="excelFileImport" accept=".xlsx,.xls" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitImportExcelBtn">Submit</button>
                    <button type="button" class="btn btn-default closeModalBtn" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    let jsonData = [];

    $(document).ready(function() {
        $("#importExcelBtn").click(function() {
            $("#modalImport").modal("show");
        });

        $(".closeModalBtn").click(function() {
            resetModal("modalImport", "importExcelForm");
        });

        $("#excelFileImport").on("change", function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = ({
                target
            }) => {
                const wb = XLSX.read(new Uint8Array(target.result), {
                    type: "array"
                });
                const sheet = wb.Sheets[wb.SheetNames[0]];

                jsonData = XLSX.utils.sheet_to_json(sheet, {
                    defval: ""
                }).map(row =>
                    Object.fromEntries(
                        Object.entries(row).map(([key, val]) => [
                            key,
                            key.toLowerCase().includes("date") ?
                            XLSX.SSF.format("yyyy-mm-dd", val) :
                            (/^\d+$/.test(val) ?
                                Number(val) :
                                (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ?
                                    val :
                                    val.toUpperCase())
                            )
                        ])
                    )
                );
            };

            reader.readAsArrayBuffer(file);
        });
    });
</script>