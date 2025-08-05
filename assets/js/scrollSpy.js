$(function () {
    const navLinks = $(".modal-scrollspy-nav .nav-link");

    navLinks.on("click", function (e) {
        e.preventDefault();

        const target = $($(this).attr("href"));
        if (!target.length) return;

        const modal = $("#modalAdd:visible, #modalEdit:visible");
        const body = modal.find(".modal-body");

        console.log(modal.attr("id"));

        const isBtn = target.attr("id")?.includes("Btn");
        const scrollTop = target.position().top + body.scrollTop() - 5;

        modal.find('.nav-link').removeClass("active");
        $(this).addClass("active");

        body.animate({ scrollTop: isBtn ? body[0].scrollHeight : scrollTop }, isBtn ? 1000 : 300);
        modal.animate({ scrollTop: isBtn ? modal[0].scrollHeight : 0 }, 300);
    });
});

$("#toggleScrollspyMenu, #editToggleScrollspyMenu").on("click", function () {
    const $btn = $(this);
    const $icon = $btn.find("i");
    const $scrollspy = $(".modal-scrollspy-nav");

    $(".scrollspy-btn-con").toggle();

    $icon.toggleClass("fa-eye fa-eye-slash");
    $btn.toggleClass("btn-primary btn-danger");
    $scrollspy.toggleClass("pull-right");
});

let resizeTimer;
$(window).on("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
        const $btn = $("#toggleScrollspyMenu:visible, #editToggleScrollspyMenu:visible");
        const $icon = $btn.find("i");

        $icon.removeClass("fa-eye-slash").addClass("fa-eye");
        $btn.removeClass("btn-danger").addClass("btn-primary");

        $(".scrollspy-btn-con").show();
    }, 200);
});