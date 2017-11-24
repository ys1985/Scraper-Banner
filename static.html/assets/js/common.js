(function($) {
    $(function() {

        var Bannnnner = (function(){
            var test;
            var $body = $('body');
            var device;
            var device_cheker;
            var $contentsSlideWrap = $('#contents-slide-wrap');
            var window_w = $(window).innerWidth();
            var $header = $('#header');

            var ResonsiveReactionInit = function(){
              $body.append('<div class="responsive-reaction"></div>');

              //IScroll
              var myscroll;
              myScroll = new IScroll('#category-nav', {
               mouseWheel: true
              });

              //masonry
              var $bnrthumbList = $('#bnrthumb-list');
              $bnrthumbList.imagesLoaded(function(){
                $bnrthumbList.masonry({
                // options
                itemSelector: '.grid-item',
                columnWidth: '.grid-item',
                percentPosition: true ,
                horizontalOrder: true
                });
              })
            }

            var ResponsiveHandler = function(){
              device = $('.responsive-reaction').css('visibility');
                if(device === "visible"){
                    device = "PC";
                }
                else{
                    device = "SP";
                }

                if(device_cheker != device){
                    device_cheker = device;
                    $body.trigger('resize:responsive');
                }
            }

            var HeaderMenu = function(){
              $('#ico-menu').click(function(e){
                e.stopPropagation();
                $contentsSlideWrap.toggleClass('active');
              })
              $('#header').click(function(e){
                if($contentsSlideWrap.hasClass('active')){
                  $contentsSlideWrap.removeClass('active');
                }
                else{
                  return false;
                }
              })
              // var headPageScroll = function(){
              //   if($(window).scrollTop() > 100){
              //       $header.addClass('fixed');
              //   }
              //   if($(window).scrollTop() < 100){
              //       $header.removeClass('fixed');
              //   }
              // }
              // $(window).on('scroll',function(){
              //   headPageScroll();
              // })
              // headPageScroll();
            }

            // var SidebarHandler = function(){
            //   $('#menu-commodity li > a').hover{
            //     function(){
            //       $(this).next().show();
            //     },
            //     function(){
            //       $(this).next().hide();
            //     }
            // }

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

            $('body').on('resize:responsive',function(){
                pagetopHandler();
            });

            return{
              ResonsiveReactionInit : ResonsiveReactionInit,
              ResponsiveHandler : ResponsiveHandler ,
              HeaderMenu : HeaderMenu
            };
        })();

        // window resize
        $(window).on('load',function(){

            Bannnnner.HeaderMenu();
            Bannnnner.ResonsiveReactionInit();
            Bannnnner.ResponsiveHandler();
        })
        // window resize
        $(window).on('resize',function(){
            Bannnnner.ResponsiveHandler();
        })

    });
})(jQuery);
