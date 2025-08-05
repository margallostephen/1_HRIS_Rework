$(document).ready(function () {
    const path = location.pathname;

    $(".sidebar-btn a").each(function () {
        if (this.pathname === path) {
            $(this).closest("li").addClass("active")
                .parents("li").addClass("active open")
                .end().parents("ul.submenu").addClass("nav-show").css("display", "block");
            return false;
        }
    });

    $(".sidebar-btn a").on("click", () => localStorage.clear());
});

function showToast(type, message, button = null) {
    toastr[type](message, type[0].toUpperCase() + type.slice(1), {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: "2000",
        extendedTimeOut: "1000",
        showDuration: "500",
        hideDuration: "2000",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        onHidden: () => button?.prop("disabled", false)
    });
}
