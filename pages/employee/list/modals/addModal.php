<button type="button" class="btn btn-primary" id="addModalBtn">Add</button>

<div id="modalAdd" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
            </div>
            <div class="modal-scrollspy-nav sticky-nav">
                <div class="scrollspy-btn-con">
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="#personalInfoScrollSpy">PERSONAL INFORMATION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contactSection">EMERGENCY CONTACT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#employmentDetailsScrollSpy">EMPLOYMENT DETAILS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#addBtn">MODAL BUTTONS</a>
                        </li>
                    </ul>
                </div>
                <div class="scrollspy-toggle-btn-con">
                    <button class="scrollspy-toggle-btn btn btn-primary" id="toggleScrollspyMenu">
                        <i class="ace-icon fa fa-eye"></i>
                    </button>
                </div>
            </div>
            <form id="addEmployeeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row" id="personalInfoScrollSpy">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="personal" class="text-center bg-info form-section">Personal Information</h4>
                            </div>
                            <div class="col-lg-12 text-center" id="profile-picture-container">
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
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName">
                            </div>
                            <div class="col-lg-6">
                                <label for="middleName">Middle Name</label>
                                <input type="text" class="form-control" id="middleName">
                            </div>
                            <div class="col-lg-10">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName">
                            </div>
                            <div class="col-lg-2">
                                <label for="suffix">Suffix <small>(Optional)</small></label>
                                <select class="form-control" id="suffix"></select>
                            </div>
                            <div class="col-lg-2">
                                <label for="birthDate">Birth Date</label>
                                <input type="text" class="form-control" id="birthDate" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="col-lg-10">
                                <label for="birthPlace">Birth Place</label>
                                <input type="text" class="form-control" id="birthPlace">
                            </div>
                            <div class="col-lg-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="civilStatus">Civil Status</label>
                                <select class="form-control" id="civilStatus"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="email@example.com">
                            </div>
                            <div class="col-lg-6">
                                <label for="contactNumber">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber">
                            </div>
                            <div class="col-lg-12" id="currentAddressLabel">
                                <h5 class="text-center"><strong>Current Address</strong></h5>
                            </div>
                            <div class="col-lg-6">
                                <label for="currentProvince">Province</label>
                                <select class="form-control" id="currentProvince"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="currentMunicipality">Municipality</label>
                                <select class="form-control" id="currentMunicipality"></select>
                            </div>
                            <div class="col-lg-3">
                                <label for="currentBarangay">Barangay</label>
                                <select class="form-control" id="currentBarangay"></select>
                            </div>
                            <div class="col-lg-7">
                                <label for="currentStreet">Street</label>
                                <input type="text" class="form-control" id="currentStreet">
                            </div>
                            <div class="col-lg-2">
                                <label for="currentZipCode">Zip Code</label>
                                <input type="text" class="form-control" id="currentZipCode">
                            </div>
                            <div class="col-lg-12" id="sameAddressContainer">
                                <input type="checkbox" id="sameAddressCheckbox"> Current address is the same as permanent address.
                            </div>
                            <div id="permanentAddressSection" class="col-lg-12">
                                <h5 class="text-center"><strong>Permanent Address</strong></h5>
                                <div class="col-lg-6">
                                    <label for="permanentProvince">Province</label>
                                    <select class="form-control" id="permanentProvince"></select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="permanentMunicipality">Municipality</label>
                                    <select class="form-control" id="permanentMunicipality"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="permanentBarangay">Barangay</label>
                                    <select class="form-control" id="permanentBarangay"></select>
                                </div>
                                <div class="col-lg-7">
                                    <label for="permanentStreet">Street</label>
                                    <input type="text" class="form-control" id="permanentStreet">
                                </div>
                                <div class="col-lg-2">
                                    <label for="permanentZipCode">Zip Code</label>
                                    <input type="text" class="form-control" id="permanentZipCode">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="contactSection">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="emergencyContact" class="text-center bg-info form-section">Emergency Contact</h4>
                            </div>
                            <div class="col-lg-4">
                                <label for="emergencyContactName">Emergency Contact Name</label>
                                <input type="text" class="form-control" id="emergencyContactName">
                            </div>
                            <div class="col-lg-4">
                                <label for="relationship">Relationship</label>
                                <input type="text" class="form-control" id="relationship">
                            </div>
                            <div class="col-lg-4">
                                <label for="emergencyContactNumber">Contact Number</label>
                                <input type="text" class="form-control" id="emergencyContactNumber">
                            </div>
                        </div>
                        <div class="row" id="employmentDetailsScrollSpy">
                            <div class="col-lg-12 form-section-header">
                                <h4 id="employment" class="text-center bg-info form-section">Employment Details</h4>
                            </div>
                            <div class="col-lg-2">
                                <label for="dateHired">Date Hired</label>
                                <input type="text" class="form-control" id="dateHired" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="col-lg-5">
                                <label for="evaluation1">Evaluation 1 <small>(After 3 Months)</small></label>
                                <input type="text" class="form-control" id="evaluation1" disabled>
                            </div>
                            <div class="col-lg-5">
                                <label for="evaluation2">Evaluation 2 <small>(After 5 Months)</small></label>
                                <input type="text" class="form-control" id="evaluation2" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="endOfProbationary">End of Probationary <small>(After 6 Months)</small></label>
                                <input type="text" class="form-control" id="endOfProbationary" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="startOfRegularization">Start of Regularization <small>(Day After Probationary)</small></label>
                                <input type="text" class="form-control" id="startOfRegularization" disabled>
                            </div>
                            <div class="col-lg-12" id="employmentStatusContainer">
                                <label for="employmentStatus">Employment Status</label>
                                <select class="form-control" id="employmentStatus"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="employeeId">Employee ID</label>
                                <input type="number" class="form-control" id="employeeId" min="0">
                            </div>
                            <div class="col-lg-6">
                                <label for="bioUserId">Biometric User ID</label>
                                <input type="number" class="form-control" id="bioUserId" min="0">
                            </div>
                            <div class="col-lg-6">
                                <label for="company">Company</label>
                                <select class="form-control" id="company"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="department">Department</label>
                                <select class="form-control" id="department"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="jobTitle">Job Title</label>
                                <select class="form-control" id="jobTitle"></select>
                            </div>
                            <div class="col-lg-6">
                                <label for="category">Category <small>(Engaged in Production Processes)</small></label>
                                <select class="form-control" id="category"></select>
                            </div>
                            <div class="col-lg-12" id="educationalAttainmentContainer">
                                <label for="educationalAttainment">Educational Attainment</label>
                                <select class="form-control" id="educationalAttainment"></select>
                            </div>
                            <div class="col-lg-12" id="courseContainer" hidden>
                                <label for="course">Course</label>
                                <input type="text" class="form-control" id="course">
                            </div>
                            <div class="col-lg-12" id="lastSchoolContainer">
                                <label for="lastSchool">Last School</label>
                                <input type="text" class="form-control" id="lastSchool">
                            </div>
                            <div class="col-lg-6">
                                <label for="previousJob">Previous Job <small>(Optional)</small></label>
                                <input type="text" class="form-control" id="previousJob">
                            </div>
                            <div class="col-lg-6">
                                <label for="previousCompany">Previous Company <small>(Optional)</small></label>
                                <input type="text" class="form-control" id="previousCompany">
                            </div>
                            <div class="col-lg-6">
                                <label for="sssNumber">SSS Number</label>
                                <input type="text" class="form-control" id="sssNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="pagibigNumber">Pagibig Number</label>
                                <input type="text" class="form-control" id="pagibigNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="pilhealthNumber">Pilhealth Number</label>
                                <input type="text" class="form-control" id="pilhealthNumber">
                            </div>
                            <div class="col-lg-6">
                                <label for="tinNumber">TIN Number</label>
                                <input type="text" class="form-control" id="tinNumber">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addBtn">Submit</button>
                    <button type="button" class="btn btn-default" id="closeModalBtn" data-dismiss="modal">Close</button>
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
    const currentProvinceSelect = createSelect2('currentProvince');
    const currentMunicipalitySelect = createSelect2('currentMunicipality');
    const currentBarangaySelect = createSelect2('currentBarangay');

    const permanentProvinceSelect = createSelect2('permanentProvince');
    const permanentMunicipalitySelect = createSelect2('permanentMunicipality');
    const permanentBarangaySelect = createSelect2('permanentBarangay');

    $(document).ready(function() {
        $("#addModalBtn").click(function() {
            $("#modalAdd").modal("show");
        });

        $("#closeModalBtn").click(function() {
            resetModal("modalAdd", "addEmployeeForm", "#suffix, #gender, #civilStatus, #currentProvince, #currentMunicipality, #currentBarangay, #permanentProvince, #permanentMunicipality, #permanentBarangay, #category, #company, #department, #jobTitle, #educationalAttainment, #employmentStatus", ['currentProvCode', 'currentMunCode', 'permanentProvCode', 'permanentMunCode']);
        });

        $("#sameAddressCheckbox").change(function() {
            if ($(this).is(":checked")) {
                $("#permanentAddressSection").hide();
            } else {
                $("#permanentAddressSection").show();
            }
        });

        $("#educationalAttainment").on("change", function() {
            const val = Number($(this).val());
            const courseContainer = $("#course").parent();
            const lastSchoolContainer = $("#lastSchool").parent();
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

        createDatePicker("#birthDate, #dateHired");

        populateSelect(
            createSelect2('suffix'),
            `suffix/get_suffix`
        );

        populateSelect(
            createSelect2('gender'),
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
            createSelect2('civilStatus'),
            `civil_status/get_civil_status`
        );

        populateSelect(currentProvinceSelect,
            `address/get_province`
        );

        populateSelect(permanentProvinceSelect,
            `address/get_province`
        );

        if (localStorage.getItem('currentProvCode')) {
            populateSelect(
                currentMunicipalitySelect,
                `address/get_municipality`
            );
        }

        if (localStorage.getItem('permanentProvCode')) {
            populateSelect(
                permanentMunicipalitySelect,
                `address/get_municipality`
            );
        }

        currentProvinceSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('currentProvCode', selectedValue);

            populateSelect(
                currentMunicipalitySelect,
                `address/get_municipality`, {
                    provCode: localStorage.getItem('currentProvCode')
                },
            );
        });

        permanentProvinceSelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('permanentProvCode', selectedValue);

            populateSelect(
                permanentMunicipalitySelect,
                `address/get_municipality`, {
                    provCode: localStorage.getItem('permanentProvCode')
                },
            );
        });

        currentMunicipalitySelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('currentMunCode', selectedValue);

            populateSelect(
                currentBarangaySelect,
                `address/get_barangay`, {
                    cityMunCode: localStorage.getItem('currentMunCode')
                },
            );
        });

        permanentMunicipalitySelect.on('change', function(e) {
            const selectedValue = $(this).val();

            localStorage.setItem('permanentMunCode', selectedValue);

            populateSelect(
                permanentBarangaySelect,
                `address/get_barangay`, {
                    cityMunCode: localStorage.getItem('permanentMunCode')
                },
            );
        });

        populateSelect(
            createSelect2('category'),
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
            createSelect2('company'),
            `company/get_company`
        );

        populateSelect(
            createSelect2('department'),
            `department/get_department`
        )

        populateSelect(
            createSelect2('jobTitle'),
            `job_title/get_job_title`
        )

        populateSelect(
            createSelect2('educationalAttainment'),
            `educ_attainment/get_educ_attainment`
        )

        populateSelect(
            createSelect2('employmentStatus'),
            `employment_status/get_employment_status`
        )
    });
</script>