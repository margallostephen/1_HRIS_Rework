$(document).ready(function () {
    $("#addRelationForm").on("submit", function (e) {
        e.preventDefault();

        const addRelationBtn = $(this).find("button[type='submit']").prop("disabled", true);

        $.ajax({
            url: `${MODULES_PATH}/relation/add_relation.php`,
            type: "POST",
            dataType: "json",
            data: {
                ir_number: $("#irNumber").val(),
                employee: $("#employee").val(),
                violation: $("#violation").val(),
                incident_date: $("#incidentDate").val(),
                action: $("#action").val(),
                reason: $("#reason").val(),

            },
            success: function (response) {
                if (!sessionValidityChecker(response, relationTable)) return;

                if (response.status) {
                    showToast("success", response.message, addRelationBtn);
                    resetModal("modalAdd", "addRelationForm", "#employee, #sanction, #violation, #action", "sanction");
                    populateTable(`relation/get_relation`, relationTable, { delete_status: 0 });
                } else {
                    showToast("warning", response.message, addRelationBtn);
                }
            },
            error: (error) => errorFunction(error, addRelationBtn)
        });
    });
});
