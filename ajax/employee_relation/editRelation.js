$(document).ready(function () {
    $("#editRelationForm").on("submit", function (e) {
        e.preventDefault();
        const RID = localStorage.getItem("editRelationId");
        const submitButton = $(this).find("button[type='submit']").prop("disabled", true);

        $.ajax({
            url: `${MODULES_PATH}/relation/edit_relation.php`,
            type: "POST",
            dataType: "json",
            data: {
                RID: RID,
                ir_number: $('#editIrNumber').val(),
                employee: $('#editEmployee').val(),
                incident_date: $('#editIncidentDate').val(),
                sanction: $('#editSanction').val(),
                violation: $('#editViolation').val(),
                action: $('#editAction').val(),
                reason: $('#editReason').val(),
            },
            success: function (response) {
                if (!sessionValidityChecker(response, relationTable)) return;

                if (response.status) {
                    showToast("success", response.message, submitButton);
                    resetModal("modalEdit", "addRelationForm", "#employee, #sanction, #violation, #action", "sanction");
                    populateTable(`relation/get_relation`, relationTable, { delete_status: 0 });
                } else {
                    showToast("warning", response.message, submitButton);
                }
            },
            error: (error) => errorFunction(error, submitButton)
        });
    });
});