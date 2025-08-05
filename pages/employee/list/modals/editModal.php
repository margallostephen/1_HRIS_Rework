<div id="modalEdit"
    class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Employee</h4>
            </div>
            <div class="modal-scrollspy-nav sticky-nav">
                <div class="scrollspy-btn-con">
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="#editPersonalInfoScrollSpy">PERSONAL INFORMATION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#editContactSection">EMERGENCY CONTACT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#editEmploymentDetailsScrollSpy">EMPLOYMENT DETAILS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#editBtn">MODAL BUTTONS</a>
                        </li>
                    </ul>
                </div>
                <div class="scrollspy-toggle-btn-con">
                    <button class="scrollspy-toggle-btn btn btn-primary" id="editToggleScrollspyMenu">
                        <i class="ace-icon fa fa-eye"></i>
                    </button>
                </div>
            </div>
            <form id="editEmployeeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row"
                            id="editPersonalInfoScrollSpy">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="personal" class="text-center bg-info form-section">Personal Information</h4>
                            </div>
                            <div class="col-lg-12 text-center"
                                id="profile-picture-container">
                                <img src="<?php echo UPLOADS_PATH . '/profile_pic/default_select_pic.jpg'; ?>"
                                    alt="Default Select Picture"
                                    id="employeePicturePreview"
                                    class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px;">

                                <input type="file"
                                    class="form-control hidden"
                                    id="employeePicture"
                                    accept="image/*"
                                    onchange="previewImage(event)">
                            </div>
                            <div class="col-lg-6">
                                <label for="editFirstName">First Name</label>
                                <input type="text" class="form-control" id="editFirstName">
                            </div>
                            <div class="col-lg-6">
                                <label for="editMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="editMiddleName">
                            </div>
                            <div class="col-lg-10">
                                <label for="editLastName">Last Name</label>
                                <input type="text" class="form-control" id="editLastName">
                            </div>
                            <div class="col-lg-2">
                                <label for="editSuffix">Suffix <small>(Optional)</small></label>
                                <select class="form-control" id="editSuffix"></select>
                            </div>
                            <div class="col-lg-2">
                                <label for="editBirthDate">Birth Date</label>
                                <input type="text" class="form-control" id="editBirthDate" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="col-lg-10">
                                <label for="editBirthPlace">Birth Place</label>
                                <input type="text" class="form-control" id="editBirthPlace">
                            </div>
                            <div class="col-lg-6">
                                <label for="editGender">Gender</label>
                                <select class="form-control" id="editGender"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editCivilStatus">Civil Status</label>
                                <select class="form-control" id="editCivilStatus"></select>
                            </div>
                            <div class="col-lg-6">
                                <labelfor="editEmail">Email</label>
                                    <input type="text" class="form-control" id="editEmail" placeholder="email@example.com">
                            </div>
                            <div class="col-lg-6">
                                <label for="editContactNumber">Contact Number</label>
                                <input type="text" class="form-control" id="editContactNumber">
                            </div>
                            <div class="col-lg-12" id="currentAddressLabel">
                                <h5 class="text-center"><strong>Current Address</strong></h5>
                            </div>
                            <div class="col-lg-6">
                                <label for="editCurrentProvince">Province</label>
                                <select class="form-control" id="editCurrentProvince"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editCurrentMunicipality">Municipality</label>
                                <select class="form-control" id="editCurrentMunicipality"></select>
                            </div>
                            <div class="col-lg-3">
                                <label for="editCurrentBarangay">Barangay</label>
                                <select class="form-control" id="editCurrentBarangay"></select>
                            </div>
                            <div class="col-lg-7">
                                <label for="editCurrentStreet">Street</label>
                                <input type="text" class="form-control" id="editCurrentStreet">
                            </div>
                            <div class="col-lg-2">
                                <label for="editCurrentZipCode">Zip Code</label>
                                <input type="text" class="form-control" id="editCurrentZipCode">
                            </div>
                            <div class="col-lg-12" id="sameAddressContainer">
                                <input type="checkbox" id="editSameAddressCheckbox"> Current address is the same as permanent address.
                            </div>
                            <div id="editPermanentAddressSection" class="col-lg-12">
                                <h5 class="text-center">
                                    <strong>Permanent Address</strong>
                                </h5>
                                <div class="col-lg-6">
                                    <label for="editPermanentProvince">Province</label>
                                    <select class="form-control" id="editPermanentProvince"></select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="editPermanentMunicipality">Municipality</label>
                                    <select class="form-control" id="editPermanentMunicipality"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="editPermanentBarangay">Barangay</label>
                                    <select class="form-control" id="editPermanentBarangay"></select>
                                </div>
                                <div class="col-lg-7">
                                    <label for="editPermanentStreet">Street</label>
                                    <input type="text" class="form-control" id="editPermanentStreet">
                                </div>
                                <div class="col-lg-2">
                                    <label for="editPermanentZipCode">Zip Code</label>
                                    <input type="text" class="form-control" id="editPermanentZipCode">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="editContactSection">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="emergencyContact" class="text-center bg-info form-section">Emergency Contact</h4>
                            </div>
                            <div class="col-lg-4">
                                <label for="editEmergencyContactName">Emergency Contact Name</label>
                                <input type="text" class="form-control" id="editEmergencyContactName">
                            </div>
                            <div class="col-lg-4">
                                <label for="editRelationship">Relationship</label>
                                <input type="text" class="form-control" id="editRelationship">
                            </div>
                            <div class="col-lg-4">
                                <label for="editEmergencyContactNumber">Contact Number</label>
                                <input type="text" class="form-control" id="editEmergencyContactNumber">
                            </div>
                        </div>
                        <div class="row" id="editEmploymentDetailsScrollSpy">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="employment" class="text-center bg-info form-section">Employment Details</h4>
                            </div>
                            <div class="col-lg-2">
                                <label for="editDateHired">Date Hired</label>
                                <input type="text" class="form-control" id="editDateHired" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="col-lg-5">
                                <label for="editEvaluation1">Evaluation 1 <small> (After 3 Months)</small></label>
                                <input type="text" class="form-control" id="editEvaluation1" disabled>
                            </div>
                            <div class="col-lg-5">
                                <label for="editEvaluation2">Evaluation 2 <small>(After 5 Months)</small></label>
                                <input type="text" class="form-control" id="editEvaluation2" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="editEndOfProbationary">End of Probationary <small>(After 6 Months)</small></label>
                                <input type="text" class="form-control" id="editEndOfProbationary" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="editStartOfRegularization">Start of Regularization <small>(Day After Probationary)</small></label>
                                <input type="text" class="form-control" id="editStartOfRegularization" disabled>
                            </div>
                            <div class="col-lg-12" id="employmentStatusContainer">
                                <label for="editEmploymentStatus">Employment Status</label>
                                <select class="form-control" id="editEmploymentStatus"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editEmployeeId">Employee ID</label>
                                <input type="number" class="form-control" id="editEmployeeId" min="0">
                            </div>
                            <div class="col-lg-6">
                                <label for="editBioUserId">Biometric User ID</label>
                                <input type="number" class="form-control" id="editBioUserId" min="0">
                            </div>
                            <div class="col-lg-6">
                                <label for="editCompany">Company</label>
                                <select class="form-control" id="editCompany"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editDepartment">Department</label>
                                <select class="form-control" id="editDepartment"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editJobTitle">Job Title</label>
                                <select class="form-control" id="editJobTitle"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="editCategory">Category <small>(Engaged in Production Processes)</small></label>
                                <select class="form-control" id="editCategory"></select>
                            </div>
                            <div class="col-lg-12" id="educationalAttainmentContainer">
                                <label for="editEducationalAttainment">Educational Attainment</label>
                                <select class="form-control" id="editEducationalAttainment"></select>
                            </div>
                            <div class="col-lg-12" id="courseContainer" hidden>
                                <label for="editCourse">Course</label>
                                <input type="text" class="form-control" id="editCourse">
                            </div>
                            <div class="col-lg-12"
                                id="lastSchoolContainer">
                                <label for="editLastSchool">Last School</label>
                                <input type="text" class="form-control" id="editLastSchool">
                            </div>
                            <div class="col-lg-6">
                                <label for="editPreviousJob">Previous Job <small>(Optional)</small></label>
                                <input type="text" class="form-control" id="editPreviousJob">
                            </div>
                            <div class="col-lg-6">
                                <label for="editPreviousCompany">Previous Company <small>(Optional)</small></label>
                                <input type="text" class="form-control" id="editPreviousCompany">
                            </div>
                            <div class="col-lg-6">
                                <label for="editSssNumber">SSS Number</label>
                                <input type="text" class="form-control" id="editSssNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="editPagibigNumber">Pagibig Number</label>
                                <input type="text" class="form-control" id="editPagibigNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="editPilhealthNumber">Pilhealth Number</label>
                                <input type="text" class="form-control" id="editPilhealthNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="editTinNumber">TIN Number</label>
                                <input type="text" class="form-control" id="editTinNumber">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editBtn">Submit</button>
                    <button type="button" class="btn btn-default" id="editCloseModalBtn" data-dismiss="modal"> Close </button>
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
<script type="text/javascript" src="<?php getJSHelper('waitOptionsChange.js') ?>"></script>
<script type="text/javascript" src="<?php getAjaxPath('employee_relation/editRelation.js') ?>">
</script>

<script type="text/javascript">
    const editCurrentProvinceSelect = createSelect2('editCurrentProvince');
    const editCurrentMunicipalitySelect = createSelect2('editCurrentMunicipality');
    const editCurrentBarangaySelect = createSelect2('editCurrentBarangay');

    const editPermanentProvinceSelect = createSelect2('editPermanentProvince');
    const editPermanentMunicipalitySelect = createSelect2('editPermanentMunicipality');
    const editPermanentBarangaySelect = createSelect2('editPermanentBarangay');

    $(document).ready(function() {
        $(document).on("click", ".editModalBtn", function() {
            $("#editCloseModalBtn").trigger("click");

            const rid = $(this).attr("data-id");
            localStorage.setItem('editEmployeeId', rid);

            const employeeList = mapData(getList("employee"), "EMPLOYEE_ID");
            const provinceList = mapData(getList("province"), "provDesc");
            const municipalityList = mapData(getList("municipality"), "citymunDesc");
            const barangayList = mapData(getList("barangay"), "brgyDesc");

            const employee = employeeList[rid]

            $("#editFirstName").val(employee.F_NAME);
            $("#editMiddleName").val(employee.M_NAME);
            $("#editLastName").val(employee.L_NAME);
            $("#editSuffix").val(employee.SUFFIX).trigger("change");
            $("#editBirthDate").val(employee.BIRTH_DATE);
            $("#editBirthPlace").val(employee.BIRTH_PLACE);
            $("#editGender").val(employee.GENDER).trigger("change");
            $("#editCivilStatus").val(employee.CIVIL_STATUS).trigger("change");
            $("#editEmail").val(employee.EMAIL);
            $("#editContactNumber").val(employee.CONTACT_NO);

            console.log(barangayList[employee.CURR_ADDR_BARANGAY].brgyCode);

            $("#editCurrentProvince").val(provinceList[employee.CURR_ADDR_PROVINCE].provCode).trigger("change");

            waitForOptionsChange("#editCurrentMunicipality", () => {
                $("#editCurrentMunicipality").val(municipalityList[employee.CURR_ADDR_MUNICIPALITY].citymunCode).trigger("change");

                waitForOptionsChange("#editCurrentBarangay", () => {
                    $("#editCurrentBarangay").val(barangayList[employee.CURR_ADDR_BARANGAY].brgyCode).trigger("change");
                });
            });


            $("#editCurrentStreet").val(employee.CURR_ADDR_STREET);
            $("#editCurrentZipCode").val(employee.CURR_ADDR_ZIP_CODE);

            // $("#editPermanentProvince").val(employee.PERM_ADDR_PROVINCE).trigger("change");
            // $("#editPermanentMunicipality").val(employee.PERM_ADDR_MUNICIPALITY).trigger("change");
            // $("#editPermanentBarangay").val(employee.PERM_ADDR_BARANGAY).trigger("change");
            // $("#editPermanentStreet").val(employee.PERM_ADDR_STREET).trigger("change");

            // $("#editSanction").val(violation.SANCTION).trigger("change");
            // setTimeout(() => $("#editViolation").val(violation.RID).trigger("change"), 100);
            // $("#editAction").val(employee.ACTION).trigger("change");
            // $("#editReason").val(employee.REASON);

            $("#modalEdit").modal("show");
        });

        $("#editCloseModalBtn").click(function() {
            resetModal("modalEdit", "editEmployeeForm", "#editSuffix, #editGender, #editCivilStatus, #editCurrentProvince, #editCurrentMunicipality, #editCurrentBarangay, #editPermanentProvince, #editPermanentMunicipality, #editPermanentBarangay, #editCategory, #editCompany, #editDepartment, #editJobTitle, #editEducationalAttainment, #editEmploymentStatus", ['editCurrentProvCode', 'editCurrentMunCode', 'editPermanentProvCode', 'editPermanentMunCode']);
        });

        $("#editSameAddressCheckbox").change(function() {
            if ($(this).is(":checked")) {
                $("#editPermanentAddressSection").hide();
            } else {
                $("#editPermanentAddressSection").show();
            }
        });

        $("#editEducationalAttainment").on("change", function() {
            const val = Number($(this).val());
            const courseContainer = $("#editCourse").parent();
            const lastSchoolContainer = $("#editLastSchool").parent();
            const educAttainment = $(this).parent();

            if (val < 5 || val === 10) {
                educAttainment
                    .removeClass("col-lg-3")
                    .addClass("col-lg-12")
                lastSchoolContainer
                    .removeClass("col-lg-6")
                    .addClass("col-lg-12")
                courseContainer.hide();
            } else {
                educAttainment
                    .removeClass("col-lg-12")
                    .addClass("col-lg-3")
                lastSchoolContainer
                    .removeClass("col-lg-12")
                    .addClass("col-lg-6")
                courseContainer.show();
            }
        });

        createDatePicker("#editBirthDate, #editDateHired");

        populateSelect(
            createSelect2('editSuffix'),
            `suffix/get_suffix`
        );

        populateSelect(
            createSelect2('editGender'),
            [{
                    RID: 1,
                    GENDER: "MALE"
                },
                {
                    RID: 2,
                    GENDER: "FEMALE"
                }
            ]
        );

        populateSelect(
            createSelect2('editCivilStatus'),
            `civil_status/get_civil_status`
        );

        populateSelect(editCurrentProvinceSelect,
            `address/get_province`
        );

        populateSelect(editPermanentProvinceSelect,
            `address/get_province`
        );

        if (localStorage.getItem('editCurrentProvCode')) {
            populateSelect(
                editCurrentMunicipalitySelect,
                `address/get_municipality`
            );
        }

        if (localStorage.getItem('editPermanentProvCode')) {
            populateSelect(
                editPermanentMunicipalitySelect,
                `address/get_municipality`
            );
        }

        editCurrentProvinceSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('editCurrentProvCode', selectedValue);

            populateSelect(
                editCurrentMunicipalitySelect,
                `address/get_municipality`, {
                    provCode: localStorage.getItem('editCurrentProvCode')
                },
            );
        });

        editPermanentProvinceSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('editPermanentProvCode', selectedValue);

            populateSelect(
                editPermanentMunicipalitySelect,
                `address/get_municipality`, {
                    provCode: localStorage.getItem('editPermanentProvCode')
                },
            );
        });

        editCurrentMunicipalitySelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('editCurrentMunCode', selectedValue);

            populateSelect(
                editCurrentBarangaySelect,
                `address/get_barangay`, {
                    cityMunCode: localStorage.getItem('editCurrentMunCode')
                },
            );
        });

        editPermanentMunicipalitySelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('editPermanentMunCode', selectedValue);

            populateSelect(
                editPermanentBarangaySelect,
                `address/get_barangay`, {
                    cityMunCode: localStorage.getItem('editPermanentMunCode')
                },
            );
        });

        populateSelect(
            createSelect2('editCategory'),
            [{
                    RID: 1,
                    CATEGORY: "DIRECT"
                },
                {
                    RID: 2,
                    CATEGORY: "INDIRECT"
                }
            ]
        );

        populateSelect(
            createSelect2('editCompany'),
            `company/get_company`
        );

        populateSelect(
            createSelect2('editDepartment'),
            `department/get_department`
        )

        populateSelect(
            createSelect2('editJobTitle'),
            `job_title/get_job_title`
        )

        populateSelect(
            createSelect2('editEducationalAttainment'),
            `educ_attainment/get_educ_attainment`
        )

        populateSelect(
            createSelect2('editEmploymentStatus'),
            `employment_status/get_employment_status`
        )
    });
</script>