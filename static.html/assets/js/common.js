(function($) {
    $(function() {

        var BannerArchive = (function(){
            var CONF = {
              $header            : $('#header'),
              $contentsSlideWrap : $('#contents-slide-wrap'),
            }

            var device;
            var device_cheker;
            var $body              = $('body');
            var $contentsSlideWrap = $('#contents-slide-wrap');
            var $window            = $(window);
            var window_w           = $(window).innerWidth();
            var $header            = $("#header");
            var $bnrthumbList      = $('#bnrthumb-list');
            var $bnrthumbListImg   = $('#bnrthumb-list .grid-item img');
            var $pc_ico_menu      = $('#ico-menu');
            var $sp_ico_menu      = $('#sp-ico-menu');

            var resonsiveReactionInit = function(){
              $body.append('<div class="responsive-reaction"></div>');

              //IScroll
              var myscroll;
              myScroll = new IScroll('#category-nav', {
               mouseWheel: true
              });

              //masonry
              $bnrthumbList.imagesLoaded(function(){

                $bnrthumbList.masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: '.grid-item',
                // percentPosition: true ,
                horizontalOrder: true
                });
              })
              resizeBannerWidthMax();
            }

            var resizeBannerWidthMax = function(){
              $bnrthumbListImg.each(function(){
                if($(this).width() > $(this).parent().width()){
                  $(this).css({width:$(this).parent().width()})
                }
              })
            }


            var responsiveHandler = function(){
              device = $('.responsive-reaction').css('visibility');
                if(device === "visible"){
                    device = "PC";
                }
                else{
                    device = "SP";
                }

                if(device_cheker != device){
                    device_cheker = device;
                    $body.trigger('trigger:responsive');
                }
            }

            var headerMenu = function(windowObj){
              $pc_ico_menu.on('click',function(e){
                e.stopPropagation();
                $contentsSlideWrap.toggleClass('active');
                if($(window).scrollTop() > 50 || $(window).scrollTop() < 50){
                  var header_w = $header.width();
                  if(device === "PC"){
                    if($contentsSlideWrap.hasClass('active')){
                      $header.css({width:header_w - 240})
                    }
                    else {
                      $header.css({width:"100%"});
                    }
                  }
                  else{
                    $header.css({width:"100%"});
                  }
                }
              })
              $sp_ico_menu.on('click',function(e){
                e.stopPropagation();
                $contentsSlideWrap.toggleClass('active');
                $sp_ico_menu.toggleClass('active');
              });
            }

            var sidebarHandler = function(){
              $('#menu-commodity > li').hover(
                function(){
                  $(this).children('.sub-menu').show();
                },
                function(){
                  $(this).children('.sub-menu').hide();
                }
              )
            }

            var pagetopHandler = function(){
              var $pagetop = $('.pagetop');
              var $body = $('body');

              var pagetopClick = function(){
                  $pagetop.on('click',function(){
                      var body_top = $('body').offset().top;
                      $('html , body') .animate({ scrollTop:body_top},300);
                  })
              }

              var pageScroll = function(windowObj){
                if(windowObj.scrollTop() > 50){
                    $header.addClass('fixed');
                }
                if(windowObj.scrollTop() < 20){
                    $header.removeClass('fixed');
                }
                  if(windowObj.scrollTop() > 100){
                      $pagetop.addClass('active');
                      $header.addClass('fixed_fix');
                  }
                  if(windowObj.scrollTop() < 100){
                      $pagetop.removeClass('active');
                      $header.removeClass('fixed_fix');
                  }
              }

              $(window).on('scroll',function(){
                  pageScroll($(this));
              })
              pagetopClick();
              pageScroll($(window));

            }

            //PC/SP responsiveTrigger
            $('body').on('trigger:responsive',function(){
                pagetopHandler();
                resizeBannerWidthMax();
                if(device === "PC"){
                  $contentsSlideWrap.addClass('active');
                }
                else if(device === "SP"){
                  $contentsSlideWrap.removeClass('active');
                  $sp_ico_menu.removeClass('active');
                }
            });

            return{
              CONF:CONF,
              sidebarHandler : sidebarHandler,
              resonsiveReactionInit : resonsiveReactionInit,
              responsiveHandler : responsiveHandler ,
              headerMenu : headerMenu ,
              resizeBannerWidthMax: resizeBannerWidthMax
            };
        })();

        // window load
        $(window).on('load',function(){
            BannerArchive.headerMenu();
            BannerArchive.sidebarHandler();
            BannerArchive.resonsiveReactionInit();
            BannerArchive.responsiveHandler();
        })

        // window resize
        $(window).on('resize',function(){
            if($(window).width() > 768){
              if(BannerArchive.CONF.$contentsSlideWrap.hasClass('active')){
                BannerArchive.CONF.$header.css({width:$(window).width() - 240})
              }
              else{
                BannerArchive.CONF.$header.css({width:"100%"});
              }
            }
            if($(window).width() < 960){
              BannerArchive.CONF.$header.css({width:"100%"});
            }

            BannerArchive.responsiveHandler();
        })

    });
})(jQuery);
