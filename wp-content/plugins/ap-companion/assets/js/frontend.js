(function ($, elementor) {
  "use strict";
  var ApElements = {

    init: function () {

      var widgets = {
        'ap-slider.default': ApElements.apSlider,
        'ap-slider2.default': ApElements.apSlider2,
        'ap-testimonials.default': ApElements.apTestimonials,
        'ap-team.default': ApElements.apTeam,
        'ap-ytvideosl.default': ApElements.apYtvideosl,
        'ap-services.default': ApElements.apServices,
        'ap-blog-post.default': ApElements.apBlogPosts,
        'ap-blog-slider.default': ApElements.apBlogSlider,
        'ap-navbar.default': ApElements.apNavbar,
        'ap-header-icon.default': ApElements.apHeaderIcons,
        'ap-offcanvas.default': ApElements.apOffcanvas,
        'ap-woo-categories.default': ApElements.apWooCategories,
        'ap-jewellery-slider-product.default': ApElements.apProductSlider

      };

      $.each(widgets, function (widget, callback) {
        elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
      });
      elementor.hooks.addAction( 'frontend/element_ready/section', ApElements.elementorSection );

    },

    apProductSlider: function( $scope ) {
        
        
        var $section   = $scope;
        $.each($section, function( index ) {
        var $element      = $(this),
        $elementFound = $element.find('.sml-jewellery-wrap .sml-jewell-products ul');

        if ($elementFound.length) {
          $elementFound.not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: false,
            dots: true,
            responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              },
              {
                breakpoint: 966,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                }
              },
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                }
              },
              ]
          });
        }
        });
           
    },


    apSlider: function ($scope) {

      var arrowsVal = $('.ap-companion-slider .slider-wrapp').attr('data-arrow');
      var pagerVal  = $('.ap-companion-slider .slider-wrapp').attr('data-pager');

      if( arrowsVal === 'yes' ){
        arrowsVal = true;
      }else{
        arrowsVal = false;
      }

      if( pagerVal === 'yes' ){
        pagerVal = true;
      }else{
        pagerVal = false;
      }

      $('.ap-companion-slider .slider-wrapp').each(function () {
        $(this).not('.slick-initialized').slick({
          infinite: true,
          arrows: arrowsVal,
          dots: pagerVal
        });
      });

    },

        /**
        * slider 2
        */
        apSlider2: function ($scope) {

          var arrowsVal = $('.ap-companion-slider2 .slider-wrapp').attr('data-arrow');
          var pagerVal  = $('.ap-companion-slider2 .slider-wrapp').attr('data-pager');

          if( arrowsVal === 'yes' ){
            arrowsVal = true;
          }else{
            arrowsVal = false;
          }

          if( pagerVal === 'yes' ){
            pagerVal = true;
          }else{
            pagerVal = false;
          }

          $('.ap-companion-slider2 .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: arrowsVal,
              dots: pagerVal
            });
          });

        },

         /**
        * testimonial slider
        */
        apTestimonials: function ($scope) {

          $('.ap-companion-testimonials.default .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 3,
              slidesToScroll: 3,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                }
              },
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                }
              },
              ]
            });
          });

          $('.ap-companion-testimonials.layout2 .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 2,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              }
              ]
            });
          });
          $('.ap-companion-testimonials.layout4 .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 1,
              slidesToScroll: 1
            });
          });
          $('.ap-companion-testimonials.layout3 .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 2,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 500,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              }
              ]
            });
          });
          $('.ap-companion-testimonials.layout5 .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 1,
              slidesToScroll: 1,
            });
          });
        },

        apTeam: function ($scope) {

          $('.ap-companion-team.default .slider-wrapp').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: true,
              dots: false,
              slidesToShow: 3,
              slidesToScroll: 3,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                }
              },
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                }
              },
              ]
            });
          });

        },

        apYtvideosl: function ($scope) {

          $('.ap-companion-ytvideosl.lay-slider .ap-companion-video-thumbnails').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: true,
              dots: false,
              slidesToShow: 2,
              slidesToScroll: 2,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
              },
              ]
            });
          });

        },

        apServices: function ($scope) {

          $('.ap-companion-services.default .slider-wrapp').each(function () {
            
            var sliderCount = $(this).attr('data-count');

            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: true,
              dots: false,
              slidesToShow: sliderCount,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                }
              },
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                }
              },
              ]
            });
          });

          $('.ap-companion-services.layout2 .slider-wrapp').each(function () {
            var sliderCount = $(this).attr('data-count');
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: sliderCount,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                }
              },
              ]
            });
          });

          $('.ap-companion-services.layout3 .slider-wrapp').each(function () {
            var sliderCount = $(this).attr('data-count');
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: true,
              dots: false,
              slidesToShow: sliderCount,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                }
              },
              ]
            });
          });
          $('.ap-companion-services.layout4 .slider-wrapp').each(function () {
            var sliderCount = $(this).attr('data-count');
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: true,
              dots: false,
              slidesToShow: sliderCount,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                }
              },
              ]
            });
          });

        },

        apBlogPosts: function ($scope) {

          $('.ap-blog-post-main-wrapp.style6').each(function () {
            $(this).not('.slick-initialized').slick({
              infinite: true,
              arrows: false,
              dots: true,
              slidesToShow: 3,
              slidesToScroll: 1,
              responsive: [
              {
                breakpoint: 426,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 2,
                }
              },
              ]
            });
          });

        },

        apBlogSlider: function($scope){


          $('.ap-blog-slider .ap-slider-preview-wrapp').not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            asNavFor: '.ap-blog-slider .ap-slider-thumb-wrapp'
          })



          $('.ap-blog-slider .ap-slider-thumb-wrapp').not('.slick-initialized').slick({
            slidesToShow: 3,
            slidesToScroll: 3,
            asNavFor: '.ap-blog-slider .ap-slider-preview-wrapp',
            dots: false,
            centerMode: false,
            centerPadding: 0,
            focusOnSelect: true,
            vertical: true,
            responsive: [
            {
              breakpoint: 1366,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
              }
            },
            {
              breakpoint: 966,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }

            ]
          });
        },

        apNavbar: function( $scope ) {

          jQuery(document).ready(function ($) {
            if ($('#ap-mob-side-nav').length > 0) {
              var $menu = $("#ap-mob-side-nav").mmenu({
                "extensions": [
                "pagedim-black",
                "border-full",
                "multiline",
                "effect-listitems-slide",
                "theme-dark"
                ]
              });
              var API = $menu.data("mmenu");

              var $icon = $(".ap-nav-icon");

              $icon.on("click", function () {
                $('.mm-page').removeAttr('style');
                API.open();
              });

              API.bind("opened", function () {
                setTimeout(function () {
                  $icon.addClass("is-active");

                }, 100);
              });

              API.bind("closed", function () {
                setTimeout(function () {
                  $icon.removeClass("is-active");
                  $('.mm-page').removeAttr('style');
                }, 100);
              });
            }
          });


        },

        apHeaderIcons: function( $scope ) {

          $('body') .on('click','.ap-header-searchbox .searchbox-icon', function(){
            $('.ap-header-searchbox').toggleClass('active');
          });

          $('body') .on('click','.ap-header-searchbox .search-close', function(){
            $('.ap-header-searchbox').toggleClass('active');
          });

        },

        apOffcanvas: function( $scope ) {

          $('body') .on('click','.ap-offcanvas-button,.ap-offcanvas-close', function(){
            $('.ap-offcanvas').toggleClass('active');
          });


        },


        apWooCategories: function( $scope ) {

           var $section   = $scope;

            $.each($section, function( index ) {
            var $element      = $(this),
            $elementFound = $element.find('.ap-woo-categories .menu-title');

            if ($elementFound.length) {
               $elementFound.click(function(){
                
                $(this).toggleClass('active');
                $(this).next('.menus-wrapp').toggleClass('active');
              });
           }
            
          });


          


        },


        elementorSection: function( $scope ) {

          var $section   = $scope,
          instance   = null,
          sectionID  = $section.data('id');

          //sticky fixes for inner section.
          $.each($section, function( index ) {
            var $sticky      = $(this),
            $stickyFound = $sticky.find('.elementor-element.ap-sticky-bar');

            if ($stickyFound.length) {
              $stickyFound.stickySidebar({
                topSpacing: 10,
                bottomSpacing: 10
              });

            }
          });
        }

      


      };

      $(window).on('elementor/frontend/init', ApElements.init);

    }(jQuery, window.elementorFrontend));
