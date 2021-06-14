jQuery(document).ready(function($){

    // Pre Loader
    $(window).load(function () {
        // Animate loader off screen
        $(".wp-store-preloader").fadeOut("slow");
      });
    var winwidth = $(window).width();
    if(winwidth <= 980) {
        $('.menu-item-has-children, .page_item_has_children').append('<i class="fa fa-caret-down menu-caret"></i>');
        $('.main-navigation ul.sub-menu,.main-navigation ul.children').hide();
        $('body').on('click','.main-navigation.toggled .menu-caret',function(){
           $(this).siblings('ul.sub-menu,ul.children').slideToggle();
        });
    }
   	// header search option
    $('.header-search > a').click(function(){
    	$('.search-box').toggleClass('search-active');
    });
    $('.header-search .close').click(function(){
      $('.search-box').removeClass('search-active');
    });    

    // For Call to actio video widget
    $(".various").fancybox({
     'transitionIn'  : 'none',
     'transitionOut' : 'none',
     'showCloseButton' : true,  
     'showNavArrows' : true,
   });

    // Wishlist count ajax update
    $( 'body' ).on( 'added_to_wishlist', function () {
      $( '.wishlist-box' ).load( yith_wcwl_plugin_ajax_web_url + ' .wishlist-box .quick-wishlist', { action: 'yith_wcwl_update_single_product_list' } );
    } );
    $( 'body' ).on( 'removed_from_wishlist', function () {
      $( '.wishlist-box' ).load( yith_wcwl_plugin_ajax_web_url + ' .wishlist-box .quick-wishlist', { action: 'yith_wcwl_update_single_product_list' } );
    } );
    $( 'body' ).on( 'added_to_cart', function () {
      $( '.wishlist-box' ).load( yith_wcwl_plugin_ajax_web_url + ' .wishlist-box .quick-wishlist', { action: 'yith_wcwl_update_single_product_list' } );
    } );

    //back to top button
    $('#back-to-top').css('right',-65);
    $(window).scroll(function(){
      if($(this).scrollTop() > 300){
        $('#back-to-top').css('right',20);
      }else{
        $('#back-to-top').css('right',-65);
      }
    });

    $("#back-to-top").click(function(){
      $('html,body').animate({scrollTop:0},600);
    });

    $('.main-navigation .close').click(function(){
      $('.main-navigation').removeClass('toggled');
    });
    $('.main-navigation ul.nav-menu').scroll(function(){

      if($(this).scrollTop() > 10){
        $('.main-navigation .close').hide('slow');
      }else{
       $('.main-navigation .close').show('slow');
     }
   });

    $(window).on("load",function(){
      $(".header-cart .widget_shopping_cart_content > ul").mCustomScrollbar();
    });
    
/*==== ===========Login Popup=========================*/
    //appends an "active" class to .popup and .popup-content when the "Open" button is clicked
function noScroll() {
 window.scrollTo(0, 0);
}

$(".loginboxtop").on("click", function() 
{
      //$('body').on('wheel.modal mousewheel.modal', function () {return false;});
      // add listener to disable scroll
        window.addEventListener('scroll', noScroll);
      $("#loginSignup1, .regbox").removeClass("active");
      $("#loginSignup, .loginbox").addClass("active");
  
});

$(".signupboxtop").on("click", function() 
{
  //$('body').on('wheel.modal mousewheel.modal', function () {return false;});
   // add listener to disable scroll
        window.addEventListener('scroll', noScroll);
  $("#loginSignup, .loginbox").removeClass("active");
  $("#loginSignup1, .regbox").addClass("active");
  $("#loginSignup1").css("overflow-y","auto");
});

//removes the "active" class to .popup and .popup-content when the "Close" button is clicked 
$(".close").on("click", function() {
   //$('body').off('wheel.modal mousewheel.modal');
   // Remove listener to re-enable scroll
window.removeEventListener('scroll', noScroll);
  $("#loginSignup, .loginbox").removeClass("active");
  $("#loginSignup1, .regbox").removeClass("active");
  

});
/*==== ===========Login Popup=========================*/

jQuery('body').delegate('#cst_addtocart_data','click',function(e) 
{
  e.preventDefault();
  jQuery(this).addClass('adding-cart');
  var cartdata = jQuery("#cst_getproduct").serialize();
  console.log('cartdata ' +cartdata);
   jQuery('#customize-preloader').show();
  
var ajaxurl = "../wp-content/themes/wp-store/ajax-files/ajax_post_data.php";

          jQuery.ajax ({
            url: ajaxurl,
            type:'POST',
            /*data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,*/
            data:'action=crispshop_add_cart&'+cartdata,
            success:function(results) 
            {
              jQuery('#Viewaddtocart_data').append(results);
               jQuery('#customize-preloader').hide();
              /*var cartcount = jQuery('.item-count').html();
              jQuery('.cart-totals span').html(cartcount);
              jQuery('html, body').animate({ scrollTop: 0 }, 'slow');*/
                     
            }
          });
      
});

jQuery('body').delegate('#cst_getproduct_data','click',function(e) 
{
  e.preventDefault();
  var cartdata = jQuery("#cst_getproduct").serialize();
  //console.log('cartdata ' +cartdata);
//var ajaxurl = "https://image.icarefurnishers.com/api/Image/GetImage";
    jQuery('#customize-preloader').show();
var ajaxurl = "../wp-content/themes/wp-store/ajax-files/ajax_post_data.php";
          jQuery.ajax ({
            url: ajaxurl,
            type:'POST',
            /*data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,*/
            data:'action2=getproductimages&'+cartdata,
            success:function(results) 
            {
              //console.log('results' + results);

             // jQuery('#cst_getproduct').append(results);
              jQuery("#custom_prd_slider #slidermain_img").attr("src",results);
              jQuery('#customize-preloader').hide();
                                   
            }
          });
      
});

jQuery('body').delegate('.term_list_all','click',function() 
{
    var cartdata = jQuery("#cst_getproduct").serialize();
    var termkey = jQuery(this).data('termkey');
    jQuery("."+termkey).removeClass('active');
    var termid = jQuery(this).attr('id');
    jQuery("."+termid).addClass('active');

  //console.log('cartdata ' +cartdata);
//var ajaxurl = "https://image.icarefurnishers.com/api/Image/GetImage";
   jQuery('#customize-preloader').show();
var ajaxurl = "../wp-content/themes/wp-store/ajax-files/ajax_post_data.php";
          jQuery.ajax ({
            url: ajaxurl,
            type:'POST',
            /*data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,*/
            data:'action2=getproductimages&'+cartdata,
            success:function(results) 
            {
              //console.log('results' + results);
              //jQuery('#Viewaddtocart_data').append(results);
              jQuery("#custom_prd_slider #slidermain_img").attr("src",results);
              jQuery('#customize-preloader').hide();
                                   
            }
          });
      
});

jQuery('body').delegate('.term_list','click',function() 
{
    var selectedVal = "";
    var termkey = "";
    var product_id = "";
    //var selectedVal = $("input[type='radio']:checked").val();
    selectedVal = $(this).val();
    termkey = $(this).data('termkey');
    product_id = $(this).data('pid');
     jQuery('#customize-preloader').show();
    //alert(termkey);
  if(selectedVal)
  {
var ajaxurl = "../wp-content/themes/wp-store/ajax-files/ajax_post_data.php";
          jQuery.ajax ({
            url: ajaxurl,
            type:'POST',
            /*data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,*/
            data:'action3=getAttrProductimages&radioValue='+selectedVal+'&termkey='+termkey+'&product_id='+product_id,
            success:function(results) 
            {
              //console.log('results' + results);
              jQuery("#custom_prd_slider #slidermain_img").attr("src",results);
               jQuery('#customize-preloader').hide().delay(2000);
                     
            }
          });
      }
      
});

jQuery('body').delegate('.RemoveCartAll','click',function() 
{   
var ajaxurl = "../wp-content/themes/wp-store/ajax-files/ajax_post_data.php";
          jQuery.ajax ({
            url: ajaxurl,
            type:'POST',
            /*data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,*/
            data:'actionremove=RemoveCartData',
            success:function(results) 
            {
              //console.log('results' + results);
             location.reload(true);
                                 
            }
          });
     
});


// Home Slider js
jQuery('#home-page-slider').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: false,
	autoplay:true,
	autoplayHoverPause: true,
	rewind:true,
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

  //jQuery.noConflict();
 jQuery('#custom_prd_slider').owlCarousel({
            loop:true,
            center: true,
            nav:false,
            items:1,
             margin:10,
            autoHeight:true,
            autoHeightClass: 'owl-height'
});

var slidesPerPage = 6;
$('#thumbnailSlider').find(".owl-item").removeClass("active");
// carousel function for thumbnail slider
$('#thumbnailSlider').owlCarousel({
        items: slidesPerPage,
        dots: true,
        nav: true,
        justify: true,
        smartSpeed: 200,
        slideSpeed: 500,
        slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
        responsiveRefreshRate: 100
}).on('click', '.owl-item img', function () 
{
jQuery(this).addClass("active");
var src = jQuery(this).attr('src');
//alert(src);
jQuery("#custom_prd_slider img").attr('src',src);


});
//-------------------------------------------------------------------------------------
  }); //doc close
