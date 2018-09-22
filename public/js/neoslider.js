/**
 * Version        :  0.0.1
 * Author         :  Lawrence Aberba <karabutaworld@gmail.com>
 * License        :  GPLv3.0
 * Description    :  A fast, simple and clean image slider
 * Dependencies   :  jQuery Version 1 or never

                     Default configuration options for neoslider
                     Note: Do not add any 'px' to arguments for width and height because
                           they are added by default in the code
                     defaultOptions = {
                         slideWidth: 600,
                         slideHeight: 300,
                         slideSpeed: 350,
                         slideInterval: 3000,
                         tooltipTextColor: "rgba(0, 0, 0, 0.8)",
                         tooltipBackgroundColor: "#ffffff",
                         tooltipWidth: 300,
                         tooltipHeight: null,
                     };
 */

;(function($) {
    $.fn.neoslider = function(customOptions) {
    	var options = $.extend({}, $.fn.neoslider.defaultOptions, customOptions);
        var slideAllowed = true;

        var slider = $(this);
        slider.css({
            width: options.slideWidth,
            height: (options.slideHeight === null) ? "auto" : options.slideHeight
        });

        // Configure sildes
        slider.children("img").addClass("slide"); // Give each slide a className of "slide"
        slider.children("img:first").addClass("current"); // Set first slide as current

        // Set slide width with the optinal slide with
        slider.children("img").css({
            height: (options.slideHeight === null) ? "auto" : options.slideHeight,
        });

        //create textbox for each slider image alt text
        var tooltip = $("<div />", {"class":"tooltip-div"}).css({
            position: "absolute",
            top: options.tooltipOffsetTop,
            left: options.tooltipOffsetLeft,
            right: options.tooltipOffsetRight,
            padding: options.tooltipPadding,
            borderRadius: "3px",
            textAlign: "center",
            color: options.tooltipTextColor,
            textShadow: "1px 1px rgba(0,0,0,0.10)",
            // boxShadow: "1px 1px rgba(0,0,0,0.10)",
            width: options.tooltipWidth,
            height: (options.tooltipHeight !== null) ? options.tooltipHeight : "auto",
            backgroundColor: options.tooltipBackgroundColor,
            zIndex: 3
        })
        .append( $("<h2 />").html(slider.children("img.current").data("tooltipheader")) )
        .append( $("<p />").html(slider.children("img.current").data("tooltipcontent")) )
        .append($("<a />", {"href":"#", "class":"button", "text":"Read More ..."}));

        slider.append(tooltip);

        // Add navigation arrows
        var nextArrow = $("<span />", {"class":"arrow next", "html":"&raquo;"}).css({
            top: options.arrowsOffsetTop,
            right: options.arrowsOffsetSides
        });
        var prevArrow = nextArrow.clone().removeClass("next").addClass("prev").html("&laquo;").css({
            right: "0px",
            left: options.arrowsOffsetSides
        });
        slider.append(nextArrow).append(prevArrow);

        /**
         * Function called to slide to next image
         * Note: this function takes a boolen argument, true for forward slide and
           false for back slide
         */
        var _next = function(direction) {
            if (direction === null || direction === undefined) throw new Error("_next() expects a boolean argument 'direction'");

            var current = slider.children("img.current"),
                next,
                delta = 1; // -1 for back slide animation offset and +1 for forward slide offset

            if (direction) { // true boolen means slide forward
                next    = current.next();
                if (!next.is("img.slide")) next = slider.children("img:first");
                delta = 1;

            } else { // "false" boolen means slide back
                next = current.prev();
                if (!next.is("img.slide")) next = slider.children("img:last");
                delta = -1;
            }


            // Fadeout tooltip
            // Note: tooltip is show after slide is updated and the tooltip's content is also updated
            tooltip.fadeOut("slow");

            // When delta is +ve, slide image will be displaced right in the animation
            // else when delta is -ve, slide image will be displaced left.
            next.animate({ opacity: 0 }, 200, "linear", function() {
                next.addClass("current"); // Set the next slide as current to bring it on top
                current.removeClass("current").addClass("previous"); // Send current slide below

                // Move the next slide back in-place to be ontop
                next.animate({opacity:1}, options.slideSpeed, "linear", function() {
                    current.removeClass("previous"); // set the replaced slide back to normal place just as the others with a z-index of zero

                    tooltip.children("h4").html(next.data("tooltipheader")); // Update tootip header
                    tooltip.children("p").html(next.data("tooltipcontent")); // Update tootip content
                    tooltip.fadeIn("slow"); // Now show the tooltip
                });

            });

        }

        // Bind event to updates 'slideAllowed' for pausing or resuming slide
        // You may also include "img.slide" in both
        slider.children(".arrow, .tooltip-div").on("mouseover focus", function() {
            slideAllowed = false;
        });

        slider.children(".arrow, .tooltip-div").on("mouseout blur", function() {
            slideAllowed = true;
        });


        // Make event binding and setInterval for forward slide
        slider.children(".next").on("click", function() {
            _next(true);
        });

        slider.children(".prev").on("click", function() {
            _next(false);
        });

        setInterval(function() {
            if (slideAllowed) _next(true);
        }, options.slideInterval);
    };

    $.fn.neoslider.defaultOptions = {
        slideWidth: "600px",
        slideHeight: "300px",
        slideSpeed: 350,
        slideInterval: 3000,
        tooltipPadding: "5px",
        tooltipTextColor: "rgba(0, 0, 0, 0.8)",
        tooltipBackgroundColor: "",
        tooltipWidth: "300px",
        tooltipHeight: "auto",
        tooltipOffsetTop: "20px",
        tooltipOffsetLeft: "20px",
        tooltipOffsetRight: "0px",
        arrowsOffsetTop: "50px",
        arrowsOffsetSides: "20px"
    };

}(jQuery));
