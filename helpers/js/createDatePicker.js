function createDatePicker(selector) {
    $(selector).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "fadeIn",
        maxDate: 0,
        showButtonPanel: false,
        defaultDate: new Date(),
    });
}

