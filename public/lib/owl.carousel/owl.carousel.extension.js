$(document).ready(function() {
    if (typeof bannerID !== 'undefined') {
        bannerOwl = $('#' + bannerID);
        bannerOwl.parent('div');

        bannerOwl.on('initialize.owl.carousel', function (prop) {
            // $(this).css({'background':'url(./images/misc/loader.gif) no-repeat center;'});
        });

        bannerOwl.on('initialized.owl.carousel', function (prop) {
            $(this).find("img").show();
            var currentIndex = prop.item.index;
            var currentEl = $(prop.target).find(".owl-item").eq(currentIndex);
            currentEl.animateCss(bannerFxIn);
            currentEl.find(".banner-caption").show();
            currentEl.find(".banner-caption").animateCss(bannerCaptionFxIn);

        });

        bannerOwl.owlCarousel({
            animateOut: bannerFxOut,
            animateIn: bannerFxIn,
            items: 1,
            loop: true,
            margin: 0,
            dots: false,
            autoplay: true,
            autoplayTimeout: autoPlayTimeout,
            autoplayHoverPause: false,
            callbacks: true,
            smartSpeed: 1000,
            nav: false,
            mouseDrag: false,
            touchDrag: false,
            pullDrag: false,
            freeDrag: false
        });

        $('#' + bannerID + ' .owl-controls').css("margin-top", "0px");

        bannerOwl.on('changed.owl.carousel', function (prop) {
            if ($(this).css('background') != 'inherit') {
                $(this).css({'background': 'inherit'});
            }
            var currentIndex = prop.item.index;
            var currentCaption = $(prop.target).find(".owl-item").eq(currentIndex).find(".banner-caption");
            currentCaption.show();
            currentCaption.animateCss(bannerCaptionFxIn);
        });
    }
});

$.fn.extend({
    animateCss: function(animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});
