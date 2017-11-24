(function($) {
    $(function() {
        var slickInitialized = function(){
            $('.slick_slider').slick({
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                infinite: true,
                autoplay : true,
                speed: 1000,
                autoplaySpeed : 2000,
                responsive: [
                   {
                     breakpoint: 768,
                     settings: {
                       slidesToShow: 1,
                       slidesToScroll: 1,
                       infinite: true,
                       dots: true,
                       swipe:true,
                       fade:false,
                       autoplay : true,
                       speed: 1000,
                       autoplaySpeed : 2000
                     }
                   }
                   // You can unslick at a given breakpoint now by adding:
                   // settings: "unslick"
                   // instead of a settings object
                 ]
            });
        }

        // window resize
        $(window).on('load',function(){
            slickInitialized();
        })

    });
})(jQuery);
