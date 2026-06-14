(function ($) {
    "use strict";

    $(document).ready(function($){

        // testimonial sliders
        $(".testimonial-sliders").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:1,
                    nav:false
                },
                1000:{
                    items:1,
                    nav:false,
                    loop:true
                }
            }
        });

        // homepage slider
        $(".homepage-slider").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            nav: true,
            dots: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1,
                    nav:false,
                    loop:true
                },
                600:{
                    items:1,
                    nav:true,
                    loop:true
                },
                1000:{
                    items:1,
                    nav:true,
                    loop:true
                }
            }
        });

        // logo carousel
        $(".logo-carousel-inner").owlCarousel({
            items: 4,
            loop: true,
            autoplay: true,
            margin: 30,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:4,
                    nav:false,
                    loop:true
                }
            }
        });

        // count down
        if($('.time-countdown').length){
            $('.time-countdown').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                var $this = $(this).html(event.strftime('' + '<div class="counter-column"><div class="inner"><span class="count">%D</span>Days</div></div> ' + '<div class="counter-column"><div class="inner"><span class="count">%H</span>Hours</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%M</span>Mins</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%S</span>Secs</div></div>'));
            });
         });
        }

        // projects filters isotop
        $(".product-filters li").on('click', function () {

            $(".product-filters li").removeClass("active");
            $(this).addClass("active");

            var selector = $(this).attr('data-filter');

            $(".product-lists").isotope({
                filter: selector,
            });

        });

        // isotop inner
        $(".product-lists").isotope();

        // magnific popup
        $('.popup-youtube').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

        // light box
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });

        // homepage slides animations
        $(".homepage-slider").on("translate.owl.carousel", function(){
            $(".hero-text-tablecell .subtitle").removeClass("animated fadeInUp").css({'opacity': '0'});
            $(".hero-text-tablecell h1").removeClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.3s'});
            $(".hero-btns").removeClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.5s'});
        });

        $(".homepage-slider").on("translated.owl.carousel", function(){
            $(".hero-text-tablecell .subtitle").addClass("animated fadeInUp").css({'opacity': '0'});
            $(".hero-text-tablecell h1").addClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.3s'});
            $(".hero-btns").addClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.5s'});
        });



        // stikcy js
        $("#sticker").sticky({
            topSpacing: 0
        });

        //mean menu
        $('.main-menu').meanmenu({
            meanMenuContainer: '.mobile-menu',
            meanScreenWidth: "992"
        });

         // search form
        $(".search-bar-icon").on("click", function(){
            $(".search-area").addClass("search-active");
        });

        $(".close-btn").on("click", function() {
            $(".search-area").removeClass("search-active");
        });

        // Filter panel appear animation and client-side validation
        if ($('.filter-panel').length) {
            // trigger animation shortly after ready for a smooth entrance
            setTimeout(function() {
                $('.filter-panel').addClass('fp-animate');
            }, 120);

            // client-side validation for price inputs
            $('.filter-panel form').on('submit', function(e) {
                var $form = $(this);
                var min = $form.find('input[name="min_price"]').val();
                var max = $form.find('input[name="max_price"]').val();
                var errors = [];

                if (min !== '' && isNaN(min)) errors.push('Le prix min doit être un nombre.');
                if (max !== '' && isNaN(max)) errors.push('Le prix max doit être un nombre.');

                var nMin = parseFloat(min);
                var nMax = parseFloat(max);
                if (!isNaN(nMin) && !isNaN(nMax) && nMin > nMax) errors.push('Le prix min ne peut pas être supérieur au prix max.');
                if (!isNaN(nMin) && nMin < 0) errors.push('Le prix min doit être positif.');
                if (!isNaN(nMax) && nMax < 0) errors.push('Le prix max doit être positif.');

                // show errors if any
                if (errors.length) {
                    e.preventDefault();
                    var $panel = $('.filter-panel');
                    var $err = $panel.find('.filter-error');
                    if (!$err.length) {
                        $err = $('<div class="filter-error" role="alert"><i class="fas fa-exclamation-circle"></i> <span class="msg"></span></div>');
                        $panel.find('form').before($err);
                    }
                    $err.find('.msg').html(errors.join('<br>'));
                    // remove error automatically after 5s
                    setTimeout(function() { $err.fadeOut(300, function(){ $(this).remove(); }); }, 5000);
                }
            });

            // prevent non-numeric input for price fields
            $('.filter-panel').on('input', 'input[name="min_price"], input[name="max_price"]', function() {
                var val = $(this).val();
                // allow empty, otherwise only digits and optional dot
                if (val !== '' && !/^\d*\.?\d*$/.test(val)) {
                    $(this).val(val.replace(/[^0-9\.]/g, ''));
                }
            });
        }

    });


    jQuery(window).on("load",function(){
        jQuery(".loader").fadeOut(1000);
    });


}(jQuery));
