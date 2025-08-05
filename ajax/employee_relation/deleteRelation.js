$(document).on("click", ".deleteBtn", function () {
    const relationId = $(this).data("id");

    Swal.fire({
        title: "Delete Relation Record",
        text: "Are you sure you want to delete this?",
        icon: "warning",
        iconColor: "#D15B47",
        showCancelButton: true,
        confirmButtonColor: "#d15b47",
        cancelButtonColor: "#428bca",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `${MODULES_PATH}/relation/delete_relation.php`,
                type: "POST",
                dataType: "json",
                data: { relation_id: relationId },
                success: function (response) {
                    if (!sessionValidityChecker(response, relationTable)) return;

                    if (response.status) {
                        showToast("success", response.message);
                        populateTable(`relation/get_relation`, relationTable, { delete_status: 0 });
                    } else {
                        showToast("warning", response.message);
                    }
                },
                error: (error) => errorFunction(error)
            });
        }
    });
});
