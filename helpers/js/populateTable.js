function populateTable(path, table, data = []) {
    const tableId = $(table.element).attr("id");
    $(`#${tableId}`).hide();
    $("#loader").show();

    $.ajax({
        url: `${MODULES_PATH}/${path}.php`,
        type: "POST",
        dataType: "json",
        data: data,
        success: function (response) {
            console.log("Response from server:", response);
            if (!sessionValidityChecker(response, table)) return;

            const tableName = tableId.split("-")[0];
            data = response.data || [];

            $("#exportExcelBtn").prop("disabled", data.length === 0);

            if (!response.status) {
                table.setData([]);
                setList(tableName, null);
                resetLoader(tableId);
                return;
            }

            setList(tableName, null, data);

            new Promise((resolve, reject) => {
                switch (tableName) {
                    case "employee": {
                        const suffixMap = mapData(getList("suffix"), "SUFFIX_ID");
                        const companyMap = mapData(getList("company"), 'COMPANY_ID');
                        const departmentMap = mapData(getList("department"), 'DEPARTMENT_ID');
                        const civilStatusMap = mapData(getList("civil_status"), "CIVIL_STATUS_ID");
                        const educAttainmentMap = mapData(getList("educ_attainment"), "EDUC_ATTAINMENT_ID");
                        const employmentStatusMap = mapData(getList("employment_status"),
                            "EMPLOYMENT_STATUS_ID");
                        const jobPositionMap = mapData(getList("job_title"), "JOB_POSITION_ID");
                        const employeeMap = mapData(getList("employee"), 'RFID');

                        data = data.map(row => ({
                            ...row,
                            M_NAME: row.M_NAME ?? "-",
                            SUFFIX: suffixMap[row.SUFFIX]?.SUFFIX ?? "-",
                            AGE: row.BIRTH_DATE && computeAge(row.BIRTH_DATE) || "-",
                            BIRTH_DATE: row.BIRTH_DATE ?? "-",
                            BIRTH_PLACE: row.BIRTH_PLACE ?? "-",
                            EMAIL: row.EMAIL ?? "-",
                            CONTACT_NO: row.CONTACT_NO ?? "-",
                            GENDER: row.GENDER == 1 ? "MALE" : "FEMALE",
                            CIVIL_STATUS: civilStatusMap[row.CIVIL_STATUS]?.CIVIL_STATUS,
                            DEPARTMENT_CODE: departmentMap[row.DEPARTMENT_ID]?.DEPARTMENT_CODE ?? "-",
                            DEPARTMENT_NAME: departmentMap[row.DEPARTMENT_ID]?.DEPARTMENT_NAME ?? "-",
                            JOB_TITLE: jobPositionMap[row.JOB_POSITION_ID]?.JOB_TITLE ?? "-",
                            COMPANY_CODE: companyMap[row.COMPANY_ID]?.COMPANY_CODE ?? "-",
                            COMPANY_NAME: companyMap[row.COMPANY_ID]?.COMPANY_NAME ?? "-",
                            CATEGORY: row.CATEGORY == 1 ? "DIRECT" : "INDIRECT",
                            CURR_ADDR_PROVINCE: row.CURR_ADDR_PROVINCE ?? "-",
                            CURR_ADDR_MUNICIPALITY: row.CURR_ADDR_MUNICIPALITY ?? "-",
                            CURR_ADDR_BARANGAY: row.CURR_ADDR_BARANGAY ?? "-",
                            CURR_ADDR_STREET: row.CURR_ADDR_STREET ?? "-",
                            CURR_ADDR_ZIP_CODE: row.CURR_ADDR_ZIP_CODE ?? "-",
                            CURRENT_FULL_ADDRESS: formatAddress({
                                province: row.CURR_ADDR_PROVINCE,
                                municipality: row.CURR_ADDR_MUNICIPALITY,
                                barangay: row.CURR_ADDR_BARANGAY,
                                street: row.CURR_ADDR_STREET,
                                zip: row.CURR_ADDR_ZIP_CODE,
                            }) ?? "-",
                            PERM_ADDR_PROVINCE: row.PERM_ADDR_PROVINCE ?? "-",
                            PERM_ADDR_MUNICIPALITY: row.PERM_ADDR_MUNICIPALITY ?? "-",
                            PERM_ADDR_BARANGAY: row.PERM_ADDR_BARANGAY ?? "-",
                            PERM_ADDR_STREET: row.PERM_ADDR_STREET ?? "-",
                            PERM_ADDR_ZIP_CODE: row.PERM_ADDR_ZIP_CODE ?? "-",
                            PERMANENT_FULL_ADDRESS: formatAddress({
                                province: row.PERM_ADDR_PROVINCE,
                                municipality: row.PERM_ADDR_MUNICIPALITY,
                                barangay: row.PERM_ADDR_BARANGAY,
                                street: row.PERM_ADDR_STREET,
                                zip: row.PERM_ADDR_ZIP_CODE,
                            }) ?? "-",
                            CONTACT_PERSON: row.CONTACT_PERSON ?? "-",
                            CONTACT_RELATION: row.CONTACT_RELATION ?? "-",
                            CONTACT_PERSON_NO: row.CONTACT_PERSON_NO ?? "-",
                            SSS_NO: row.SSS_NO ?? "-",
                            PAGIBIG_NO: row.PAGIBIG_NO ?? "-",
                            PHILHEALTH_NO: row.PHILHEALTH_NO ?? "-",
                            TIN_NO: row.TIN_NO ?? "-",
                            EDUC_ATTAINMENT: educAttainmentMap[row.EDUC_ATTAINMENT].EDUC_ATTAINMENT ?? "-",
                            COURSE: row.COURSE ?? "-",
                            LAST_SCHOOL: row.LAST_SCHOOL ?? "-",
                            PREV_JOB: row.PREV_JOB ?? "-",
                            PREV_COMPANY: row.PREV_COMPANY ?? "-",
                            STATUS: employmentStatusMap[row.STATUS].EMPLOYMENT_STATUS ?? "-",
                            SERVICE: calculateYearsOfService(row.DATE_HIRED, employmentStatusMap[row.STATUS].EMPLOYMENT_STATUS, row.LAST_DATE) ?? "-",
                            DATE_HIRED: row.DATE_HIRED ?? "-",
                            EVALUATION_3_MONTHS: calculateEvaluation(row.DATE_HIRED) ?? "-",
                            EVALUATION_5_MONTHS: calculateEvaluation(row.DATE_HIRED, 5) ?? "-",
                            END_OF_PROBATIONARY: row.END_OF_PROBATIONARY ?? "-",
                            START_OF_REGULARIZATION: row.START_OF_REGULARIZATION ?? "-",
                            DATE_SEPARATED: row.LAST_DATE ?? "-",
                            UPDATED_AT: row.UPDATED_AT ?? "-",
                            USER: employeeMap[row.UPDATED_BY ?? row.CREATED_BY]?.EMPLOYEE_NAME ?? "ADMIN",
                            ACTIVE: row.ACTIVE == 1 ? "ACTIVE" : "INACTIVE",
                            BIO_USER_ID: row.BIO_USER_ID || "-"
                        }));

                        resolve(data);
                        break;
                    }
                    case "relation": {
                        const employeeMap = mapData(getList("employee"), 'RFID');
                        const violationMap = mapData(getList("violation"));
                        const actionMap = mapData(getList("action"));
                        const companyMap = mapData(getList("company"), 'COMPANY_ID');

                        data = data.flatMap(row => {
                            const employee = employeeMap[row.EMPLOYEE_ID];
                            if (!employee) {
                                console.log(`Employee not found for EMPLOYEE_ID: ${row.EMPLOYEE_ID}`);
                                return [];
                            }
                            return {
                                ...row,
                                COMPANY: companyMap[employee.COMPANY_ID].COMPANY_CODE,
                                EMPLOYEE_NAME: employee.EMPLOYEE_NAME,
                                VIOLATION: violationMap[row.VIOLATION]?.VIOLATION_DESCRIPTION,
                                ACTION: actionMap[row.ACTION]?.ACTION_DESCRIPTION,
                            };
                        });

                        resolve(data);
                        break;
                    }
                    default:
                        reject("Invalid table ID");
                }
            })
                .then(modifiedData => {
                    table.replaceData(modifiedData);
                    resetLoader(tableId);
                }).catch(error => {
                    resetLoader(tableId);
                    console.error("Error loading data:", error);
                });
        },
        error: (error) => {
            resetLoader(tableId);
            errorFunction(error);
        }
    });
}