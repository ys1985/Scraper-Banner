(function($) {
    $(function() {
        var BannerArchive = (function(){
            var CONF = {
              $header            : $('#header'),
              $contentsSlideWrap : $('#contents-slide-wrap'),
            }

            var device;
            var device_cheker;
            var $body                    = $('body');
            var $contentsSlideWrap       = $('#contents-slide-wrap');
            var $window                  = $(window);
            var window_w                 = $(window).innerWidth();
            var $header                  = $("#header");
            var $bnrthumbList            = $('#bnrthumb-list');
            var $bnrthumbListImg         = $('#bnrthumb-list .grid-item img');
            var $pc_ico_menu             = $('#ico-menu');
            var $sp_ico_menu             = $('#sp-ico-menu');

            // var $categoryNavColorLabel   = $('#category-nav .search_taxonomie.color label.checkebox');
            // var $categoryNavLabelBubble  = $('#category-nav .search_taxonomie.color label.checkebox span.color-tip');

            var resonsiveReactionInit = function(){
              $body.append('<div class="responsive-reaction"></div>');

              //IScroll
              var myscroll;
              myScroll = new IScroll('#category-nav', {
               mouseWheel: true
              });

              //masonry
              $bnrthumbList.imagesLoaded(function(e){
                // console.log( e );
                $bnrthumbList.masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: '.grid-item',
                // percentPosition: true ,
                horizontalOrder: true
                });

                $bnrthumbList.on( 'layoutComplete', function( event, items ) {
                  console.log( items.length );
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
                return device;
            }

            var headerMenu = function(windowObj){
              //PC ico-menu
              $pc_ico_menu.on('click',function(e){
                e.stopPropagation();
                $contentsSlideWrap.toggleClass('active');
                if($(window).scrollTop() > 50 || $(window).scrollTop() < 50){
                  var header_w = $header.width();
                  if(device === "PC"){
                    if($contentsSlideWrap.hasClass('active')){
                      $header.css({width:"100%"});
                    }
                    else {
                      $header.css({width:header_w - 240})
                      // $header.css({width:"100%"});
                    }
                  }
                  else{
                    $header.css({width:"100%"});
                  }
                }
              })
              //SP ico-menu
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

            var headerScrollHandler = function(){
              var $pagetop = $('.pagetop');
              var $body = $('body');

              var pagetopClick = function(){
                  $pagetop.on('click',function(){
                      var body_top = $('body').offset().top;
                      $('html , body') .animate({ scrollTop:body_top},300);
                  })
              }

              var pageScroll = function(windowObj){

                if(device === "PC"){
                  if(windowObj.scrollTop() > 50){
                      $header.addClass('fixed');
                  }
                  if(windowObj.scrollTop() < 20){
                      $header.removeClass('fixed');
                  }
                  if(windowObj.scrollTop() > 50){
                      $pagetop.addClass('active');
                      $header.addClass('fixed_fix');
                  }
                  if(windowObj.scrollTop() < 50){
                      $pagetop.removeClass('active');
                      $header.removeClass('fixed_fix');
                  }
                }
                if(device === "SP"){
                  if($('#wpadminbar').css("display") === "block"){
                    if(windowObj.scrollTop() > 10){
                      $header.css({top:"0px"});
                      $sp_ico_menu.css({top:"0px"});
                    }
                    if(windowObj.scrollTop() < 20){
                      $header.css({top:"46px"});
                      $sp_ico_menu.css({top:"46px"});
                    }
                  }
                  else{
                    $header.css({top:"0px"});
                    $sp_ico_menu.css({top:"0px"});
                  }
                }

                return windowObj;
              }

              $(window).on('scroll',function(){
                  pageScroll($(this));
              })

              pagetopClick();
              pageScroll($window);

              return $window;

            }

            //PC/SP responsiveTrigger
            $('body').on('trigger:responsive',function(){
                headerScrollHandler();
                resizeBannerWidthMax();
                if(device === "PC"){
                  $pc_ico_menu.show();
                  $sp_ico_menu.hide();
                  // $contentsSlideWrap.addClass('active');
                  $header.css({top:"0px"});
                }
                else if(device === "SP"){
                  if($('#wpadminbar').css("display") === "block" && $window.scrollTop() < $('#wpadminbar').height()){
                      $sp_ico_menu.css({top:$('#wpadminbar').height()});
                  }
                  $sp_ico_menu.css({display:"flex"});
                  $pc_ico_menu.hide();
                  // $contentsSlideWrap.addClass('active');
                  $sp_ico_menu.addClass('active');
                }
            });

            var categoryNavColorHadler = function(){
              var $categoryNavColorLabel = $('#category-nav dl.search_taxonomie.color dd label');
              $categoryNavColorLabel.hover(
                function(){
                  $(this).next().show();
                },
                function(){
                  $(this).next().hide();
                }
              );
            }


            return{
              CONF:CONF,
              sidebarHandler : sidebarHandler,
              resonsiveReactionInit : resonsiveReactionInit,
              responsiveHandler : responsiveHandler ,
              headerMenu : headerMenu ,
              resizeBannerWidthMax: resizeBannerWidthMax ,
              categoryNavColorHadler: categoryNavColorHadler
            };
        })();

        // window load
        $(window).on('load',function(){

          $('.author-link a').on("click" , function(){
            var id = $(this).attr('data');
            document.author.author.value = id;
          });

          if($(window).width() > 768){
            if(!BannerArchive.CONF.$contentsSlideWrap.hasClass('active')){
              BannerArchive.CONF.$header.css({width:$(window).width() - 240})
            }
          }
          BannerArchive.headerMenu();
          BannerArchive.sidebarHandler();
          BannerArchive.resonsiveReactionInit();
          BannerArchive.responsiveHandler();
          BannerArchive.categoryNavColorHadler();
        })

        // window resize
        $(window).on('resize',function(){
            if($(window).width() > 768){
              if(BannerArchive.CONF.$contentsSlideWrap.hasClass('active')){
                BannerArchive.CONF.$header.css({width:"100%"});
              }
              else{
                BannerArchive.CONF.$header.css({width:$(window).width() - 240})
              }
            }
            if($(window).width() < 960){
              BannerArchive.CONF.$header.css({width:"100%"});
            }

            BannerArchive.responsiveHandler();
        })

    });
})(jQuery);
