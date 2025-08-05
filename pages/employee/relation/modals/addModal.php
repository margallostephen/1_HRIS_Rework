<button type="button" class="btn btn-primary" id="addModalBtn">Add</button>

<div id="modalAdd" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Relation</h4>
            </div>
            <form id="addRelationForm">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="irNumber">IR Number</label>
                                <input type="text" class="form-control" id="irNumber" autocomplete="off" oninput="this.value = this.value.toUpperCase()" placeholder="IR-YYYY-COMPANY-NUMBER">
                            </div>
                            <div class="col-lg-6">
                                <label for="employee">Employee Name</label>
                                <select class="form-control" id="employee"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="sanction">Sanction</label>
                                <select class="form-control" id="sanction"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="violation">Violation</label>
                                <select class="form-control" id="violation"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="incidentDate">Incident Date</label>
                                <input type="text" class="form-control" id="incidentDate" placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                            <div class="col-lg-6">
                                <label for="action">Action</label>
                                <select class="form-control" id="action"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="reasonContainer">
                                <label for="reason">Reason</label>
                                <textarea class="form-control" id="reason"
                                    oninput="this.value = this.value.toUpperCase()"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addBtn">Submit</button>
                    <button type="button" class="btn btn-default closeModalBtn" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src="<?php getAjaxPath('employee_relation/addRelation.js') ?>"></script>

<script type="text/javascript">
    const sanctionSelect = createSelect2('sanction');
    const violationSelect = createSelect2('violation');

    $(document).ready(function() {
        $("#addModalBtn").click(function() {
            $("#modalAdd").modal("show");
        });

        $(".closeModalBtn").click(function() {
            resetModal("modalAdd", "addRelationForm", "#employee, #sanction, #violation, #action", "sanction");
        });

        createDatePicker("#incidentDate");

        populateSelect(
            createSelect2('employee'),
            `employee/get_employee`
        );

        populateSelect(
            sanctionSelect,
            `sanction/get_sanction`
        );

        if (localStorage.getItem('sanction')) {
            populateSelect(
                violationSelect,
                `violation/get_violation`
            );
        }

        populateSelect(
            createSelect2('action'),
            `action/get_action`
        );

        sanctionSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('sanction', selectedValue);

            populateSelect(
                violationSelect,
                `violation/get_violation`, {
                    isSanction: true,
                    sanction: localStorage.getItem('sanction')
                },
            );
        });
    });
</script>