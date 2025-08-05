<div id="modalEdit" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Relation</h4>
            </div>
            <form id="editRelationForm">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="editIrNumber">IR Number</label>
                                <input type="text" class="form-control" id="editIrNumber" autocomplete="off" oninput="this.value = this.value.toUpperCase()" placeholder="IR-YYYY-COMPANY-NUMBER">
                            </div>
                            <div class="col-lg-6">
                                <label for="editEmployee">Employee Name</label>
                                <select class="form-control" id="editEmployee"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="editSanction">Sanction</label>
                                <select class="form-control" id="editSanction"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editViolation">Violation</label>
                                <select class="form-control" id="editViolation"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="editIncidentDate">Incident Date</label>
                                <input type="text" class="form-control" id="editIncidentDate" placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                            <div class="col-lg-6">
                                <label for="editAction">Action</label>
                                <select class="form-control" id="editAction"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="reasonContainer">
                                <label for="editReason">Reason</label>
                                <textarea class="form-control" id="editReason" oninput="this.value = this.value.toUpperCase()"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php getJSUtil('getList.js') ?>"></script>
<script type="text/javascript" src="<?php getJSUtil('setList.js') ?>"></script>
<script type="text/javascript" src="<?php getJSHelper('createSelect.js') ?>"></script>
<script type="text/javascript" src="<?php getJSHelper('populateSelect.js') ?>"></script>
<script type="text/javascript" src="<?php getJSHelper('createDatePicker.js') ?>"></script>
<script type="text/javascript" src="<?php getAjaxPath('employee_relation/editRelation.js') ?>"></script>

<script type="text/javascript">
    const editSanctionSelect = createSelect2('editSanction');
    const editViolationSelect = createSelect2('editViolation');

    $(document).ready(function() {
        $(document).on("click", ".editModalBtn", function() {
            const rid = $(this).attr("data-id");
            localStorage.setItem('editRelationId', rid);

            const employeeId = $(this).closest(".tabulator-row").find('[tabulator-field="EMPLOYEE_ID"]').text().trim();

            const relationList = mapData(getList("relation"), "RID");
            const violationList = mapData(getList("violation"));

            const employee = relationList[rid];
            const violation = violationList[employee.VIOLATION];

            $("#editIrNumber").val(employee.IR_NUMBER);
            $("#editEmployee").val(employeeId).trigger("change");
            $("#editIncidentDate").val(employee.INCIDENT_DATE);
            $("#editSanction").val(violation.SANCTION).trigger("change");
            setTimeout(() => $("#editViolation").val(violation.RID).trigger("change"), 100);
            $("#editAction").val(employee.ACTION).trigger("change");
            $("#editReason").val(employee.REASON);

            $("#modalEdit").modal("show");
        });

        createDatePicker("#editIncidentDate");

        populateSelect(
            createSelect2('editEmployee'),
            `employee/get_employee`
        );
        populateSelect(
            editSanctionSelect,
            `sanction/get_sanction`
        );

        if (localStorage.getItem('editSanction')) {
            populateSelect(
                editViolationSelect,
                `violation/get_violation`
            );
        }

        populateSelect(
            createSelect2('editAction'),
            `action/get_action`
        );

        editSanctionSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('sanction', selectedValue);

            populateSelect(
                editViolationSelect,
                `violation/get_violation`, {
                    isSanction: true,
                    sanction: localStorage.getItem('sanction')
                },
            );
        });
    });
</script>