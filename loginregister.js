$(document).ready(() => {
    console.log("Ready...");

    $("#gotoregister").click((evt) => {
        evt.preventDefault();

        $(".login").addClass("hidden");
        $(".register").removeClass("hidden");
    });

    $("#gotologin").click((evt) => {
        evt.preventDefault();

        $(".register").addClass("hidden");
        $(".login").removeClass("hidden");
    });
});

