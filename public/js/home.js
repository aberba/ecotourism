$(function() {
    var slideWidth = $(".slider").width(),
    slideHeight = 300,
    tooltipWidth  = 400,
    tooltipOffsetTop = (slideHeight / 2) + 100,
    arrowsOffsetTop = (slideHeight /2) + 40,
    tooltipOffsetLeft = (slideWidth/2) - ((tooltipWidth/2) );

    $(window).on("DOMContentLoaded", function() {
        slideWidth = $(".slider").width();
        slideHeight = $(".slider").height();
        $(window).trigger("resize");
    });

    $(document).on("resize", function() {
        slideWidth = $(".slider").width();
        tooltipOffsetTop = (slideHeight /2) + 50;
    });

    $(".slider").neoslider({
            slideWidth: "100%",
            slideHeight: "auto",
            slideSpeed: 1000,
            slideInterval: 5000,
            tooltipWidth: tooltipWidth + "px",
            tooltipOffsetTop: tooltipOffsetTop + "px",
            tooltipOffsetLeft: tooltipOffsetLeft + "px",
            tooltipBackgroundColor: "",
            tooltipTextColor: "white",
            arrowsOffsetTop: arrowsOffsetTop + "px"
    });
});
