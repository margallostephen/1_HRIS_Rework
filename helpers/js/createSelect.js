function createSelect2(selector) {
    const $element = $(`#${selector}`);
    return $element.select2({
        width: "100%",
        dropdownParent: $element.closest("div")
    });
}
