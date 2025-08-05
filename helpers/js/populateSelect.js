function populateSelect(select2, path, data = []) {
    const populateOptions = (options) => {
        select2.empty();

        if (options.length) {
            let optionsHTML = `<option value="">Select</option>`;

            // options.forEach((item) => {
            //     const keys = Object.keys(item);
            //     const value = item[keys[1]];
            //     const optionValue = employee ? item.RFID : item.RID;
            //     const optionText = employee
            //         ? `${item.RFID} - ${item.EMPLOYEE_NAME}`
            //         : value;

            //     optionsHTML += `<option value="${optionValue}">${optionText}</option>`;
            // });

            options.forEach((item) => {
                let optionValue = "";
                let optionText = "";

                const id = select2.attr("id").toLowerCase();

                console.log(id)

                switch (true) {
                    case id.includes("employee"):
                        optionValue = item.RFID;
                        optionText = `${item.RFID} - ${item.EMPLOYEE_NAME}`;
                        break;

                    case id.includes("company"):
                        optionValue = item.COMPANY_ID;
                        optionText = item.COMPANY_NAME;
                        break;

                    case id.includes("department"):
                        optionValue = item.DEPARTMENT_ID;
                        optionText = `${item.DEPARTMENT_CODE} - ${item.DEPARTMENT_NAME}`;
                        break;

                    case id.includes("province"):
                        optionValue = item.provCode;
                        optionText = item.provDesc;
                        break;

                    case id.includes("municipality"):
                        optionValue = item.citymunCode;
                        optionText = item.citymunDesc;
                        break;

                    case id.includes("barangay"):
                        optionValue = item.brgyCode;
                        optionText = item.brgyDesc;
                        break;

                    default:
                        const keys = Object.keys(item);
                        optionValue = item[keys[0]];
                        optionText = item[keys[1]] ?? item[keys[0]];
                        break;
                }

                optionsHTML += `<option value="${optionValue}">${optionText}</option>`;
            });


            select2.append(optionsHTML);
        } else {
            select2.append(`<option value="">No options available</option>`);
        }

        select2.trigger("change");
    };

    if (Array.isArray(path)) {
        populateOptions(path);
    } else {
        $.ajax({
            url: `${MODULES_PATH}/${path}.php`,
            type: "POST",
            data: data,
            dataType: "json",
            success: function (response) {
                const options = response.data || [];
                populateOptions(options);
            },
            error: (error) => errorFunction(error),
        });
    }
}
