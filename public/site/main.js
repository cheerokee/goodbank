/**

* Template Name: Finance - Multipurpose Business Responsive HTML Site Template  
* Version: 1.0
* Author: HidraTheme 
* Developed By: HidraTheme  
* Author URL: https://themeforest.net/user/hidratheme

NOTE: This is the custom js file for the template

**/


(function ($) {

  
    "use strict"; 
    
    /*=================== PRELOADER ===================*/
    $(window).on('load',function() { 
        $(".preloading").fadeOut("slow"); 
    });


    /*=================== TOP NAVIGATION =================== */
    $('button.navbar-toggle').on("click", function() {
    $( 'body' ).toggleClass( 'open-mobile-menu' );
      }); 

    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault(); 
            event.stopPropagation(); 
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
            });

    // ======================= HOMEPAGE SLIDER  ======================= // 
    if($('#home-slider').length > 0){
        $("#home-slider").owlCarousel({
          dots: false,
          loop: true,
          autoplay: true,
          slideSpeed : 2000,
          margin: 0,
          responsiveClass: true,
          nav: false, 
             navText: ["<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>", "<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>"], 
          responsive: {
            0: {
              items: 1,
              nav: true
            },
            480: {
              items: 1,
              nav: true
            },
            600: {
              items: 1,
              nav: true
            },
            1000: {
              items: 1,
              nav: true,
              loop: true,
              margin: 0
            }
          }
           
        });
    }


    // ======================= HOMEPAGE SLIDER ANIMATE.CSS  ======================= // 
    // Declare Carousel jquery object
    var owl = $('#home-slider');

    // Carousel initialization
    owl.owlCarousel({
        loop:true,
        margin:0,
        navSpeed:500,
        nav:true,
        items:1
    });

    // add animate.css class(es) to the elements to be animated
    function setAnimation ( _elem, _InOut ) {
      // Store all animationend event name in a string.
      // cf animate.css documentation
      var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

      _elem.each ( function () {
        var $elem = $(this);
        var $animationType = 'animated ' + $elem.data( 'animation-' + _InOut );

        $elem.addClass($animationType).one(animationEndEvent, function () {
          $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
        });
      });
    }

    // Fired before current slide change
    owl.on('change.owl.carousel', function(event) {
        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-out]");
        setAnimation ($elemsToanim, 'out');
    });

    // Fired after current slide has been changed
    owl.on('changed.owl.carousel', function(event) {

        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-in]");
        setAnimation ($elemsToanim, 'in');
    })

     

    // ======================= STELLAR  ======================= //
    $(function(){
      $.stellar({
        horizontalScrolling: false,
        verticalOffset: 40
      });
    }); 

    /*=================== STICKY MENU ===================*/ 
     $(window) .scroll(function() {
        if(jQuery(this).scrollTop() > 50) {
           $('header').addClass('sticky');
        } else {
           $('header').removeClass('sticky'); 
        }
     });

    /*=================== ACTIVE MENU ===================*/
     $('.navbar-nav > li a').on("click", function() {
        $('.navbar-nav').find('li.active').removeClass('active'); 
        $(this).parents("li").addClass('active');
    }); 
 
    // ======================= JQUERY FOR SCROLLING FEATURE ======================= // 
    $('a.page-scroll').on("click", function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

    // ======================= COUNTER NUMBER  ======================= //
      $('#playcounter').on('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
          $(this).find('.count').each(function () {
            var $this = $(this);
            $({ Counter: 0 }).animate({ Counter: $this.text() }, {
              duration: 12000,
              easing: 'swing',
              step: function () {
                $this.text(Math.ceil(this.Counter));
              }
            });
          });
          $(this).unbind('inview');
        }
      });

    // ======================= HOMEPAGE BLOG  ======================= // 
    if($('#blog-carousel').length > 0){
        $("#blog-carousel").owlCarousel({
          dots: false,
          loop:true,
    margin:10, 
    autoplay: true,
                            autoplayTimeout: 9000,
    smartSpeed: 2000, // duration of change of 1 slide
    responsiveClass:true,
          nav: false, 
               navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"], 
          responsive: {
            0: {
              items: 1,
              nav: true
            },
            480: {
              items: 1,
              nav: true
            },
            600: {
              items: 2,
              nav: true,
              margin: 10
            },
            768: {
              items: 3,
              nav: true,
              margin: 20
            },
            1000: {
              items: 3,
              nav: true,
              loop: true,
              margin: 20
            },
            1200: {
              items: 3,
              nav: true,
              loop: true,
              margin: 20
            }
          }
           
        });
    }

    // ======================= TESTIMONIAL  ======================= // 
     if($('#testimonial').length > 0){
        $("#testimonial").owlCarousel({
          dots: true,
          loop: true,
          autoplay: true,
          slideSpeed : 2000,
          margin: 0,
          responsiveClass: true,
          nav: true, 
             navText: ["<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>", "<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>"], 
          responsive: {
            0: {
              items: 1,
              nav: false
            },
            480: {
              items: 1,
              nav: false
            },
            600: {
              items: 1,
             nav: false
            },
            1000: {
              items: 2,
              nav: false, 
              margin: 0
            }
          }
           
        });
    }

    /*=================== GALLERY FILTERING FUCTION  ===================*/
    $(function() {
    var selectedClass = "";
    $(".fil-cat").on("click", function(){ 
    selectedClass = $(this).attr("data-rel"); 
     $("#portfolio").fadeTo(100, 0.1);
    $("#portfolio div").not("."+selectedClass).fadeOut().removeClass('scale-anm');
    setTimeout(function() {
      $("."+selectedClass).fadeIn().addClass('scale-anm');
      $("#portfolio").fadeTo(300, 1);
    }, 300); 
    
      });
    });

    /*=================== MAGNIFICPOPUP GALLERY  ===================*/
     $(".gallery-list").magnificPopup({
          type: "image",
          removalDelay: 300 
      });

     /*======================= GO TO TOP FUCTION  =======================*/
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').on("click", function() {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
    /*=================== THEME COLOR PANEL FUNCTIONS ===================*/
    $(".style-option-wrap #style-btn").on("click", function() {
        $(this).parent(".style-option-wrap").toggleClass("open-style");
    });

    /*=================== THEME COLOR FUNCTIONS ===================*/
    $(".theme-panel #theme-default").on("click", function() {
        $("body").removeAttr('class');
    });

    $('#theme-orange,#theme-green,#theme-blue,#theme-red,#theme-greenleaf').on("click", function() {
        var style = this.id;
        $("body").attr('class', style);
    });



 })(jQuery);

