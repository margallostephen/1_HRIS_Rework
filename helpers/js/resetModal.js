function resetModal(modalId, formId, selectIds, localStorageKeys = null) {
    const $modal = $(`#${modalId}`);

    $modal.modal("hide");
    $(`#${formId}`)[0].reset();

    if (localStorageKeys) {
        for (const key of localStorageKeys) {
            localStorage.removeItem(key);
        }
    }

    $(selectIds).val("").trigger("change");

    $modal.scrollTop(0);
    $modal.find(".modal-body").scrollTop(0);
    $modal.find(".nav-link").removeClass("active").eq(0).addClass("active");
    $modal.find(".scrollspy-btn-con").show();

    const $btn = $modal.find("#toggleScrollspyMenu, #editToggleScrollspyMenu");
    const $icon = $btn.find("i");

    $icon.removeClass("fa-eye-slash").addClass("fa-eye");
    $btn.removeClass("btn-danger").addClass("btn-primary");
    $(".scrollspy-btn-con").show();
}
