// ******************************************* //
// ********** Farmie Template Js ************* //
// ******************************************* //

(function ($) {
    'use strict';

    let browserWindow = $(window);
    let welcomeSlide = $('.welcome-slides');


    // :: 5.0 Sliders Active Code
    if ($.fn.owlCarousel) {
        welcomeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });

        welcomeSlide.on('translate.owl.carousel', function () {
            let slideLayer = $("[data-animation]");
            slideLayer.each(function () {
                let anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        welcomeSlide.on('translated.owl.carousel', function () {
            let slideLayer = welcomeSlide.find('.owl-item.active').find("[data-animation]");
            slideLayer.each(function () {
                let anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });

        $("[data-delay]").each(function () {
            let anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function () {
            let anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        $('.testimonial-slides').owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            dots: false,
            nav: true,
            navText: ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'],
            autoplay: true,
            autoplayTimeout: 4000,
            smartSpeed: 1000,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
    }
})(jQuery);
