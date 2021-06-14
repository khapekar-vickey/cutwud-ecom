jQuery(document).ready(function() 
	{
    });// end ready
jQuery('body').delegate('.single_add_to_cart_button','click',function(e)
{
	e.preventDefault();
  
//alert(11);
var cnt=0;
var cnt1=0;

jQuery( "select" ).each(function( index, element ) 
{
  cnt = cnt+1;
                // element == this
                if(jQuery(this).val()==""){
                  
                  jQuery( this ).css( "border", "1px solid red" );
                  //alert('Please select an option!!');
                  
                }else{
                      jQuery( this ).css( "border", "1px solid green" );
                      cnt1 = cnt1+1;
                  
                }
              // jQuery( element ).css( "backgroundColor", "yellow" );
              if(cnt == cnt1){
                return true;
              }
             
   });
//console.log(cnt+' '+cnt1);

          
if(cnt != cnt1){
     /*jQuery("select").each(function(i){
        alert($(this).text() + " : " + $(this).val());
    });*/
    alert('Oops! Please select an option to continue.');
}else{
  jQuery('.viewcart-btn .loader').show();
  jQuery(this).addClass('adding-cart');
  var cartdata = jQuery("#preorderFrmSubmit").serialize();
      			jQuery.ajax ({
      			url: ajaxurl,
      			type:'POST',
      			data:cartdata,
      			success:function(results,textStatus, jqXHR) {
              jQuery('.loader').hide();
      				jQuery('.viewcart-btn').append(results);
      				jQuery('.single_add_to_cart_button').removeClass('adding-cart');
      				jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
                      /*setTimeout(function () { 
                          jQuery('.viewcart-btn').html('');
                      }, 3000);*/
      			}
      		});
    }

	});

jQuery('body').delegate('.single_add_to_cartbutton','click',function(e) {
  e.preventDefault();
  jQuery(this).addClass('adding-cart');
  /*var product_id = jQuery(this).val();
  alert(product_id);*/
  var product_id = jQuery(this).data('product_id');
  var variation_id = jQuery('input[name="variation_id"]').val();
  var quantity = jQuery('input[name="quantity"]').val();
  //console.log('product_id ' +product_id);
  jQuery('.cart-dropdown-inner').empty();

  if (variation_id != '') {
    jQuery.ajax ({
      url: ajaxurl,
      type:'POST',
      data:'action=crispshop_add_cart_single&product_id=' + product_id + '&variation_id=' + variation_id + '&quantity=' + quantity,

      success:function(results) {
        jQuery('.cart-dropdown-inner').append(results);
        var cartcount = jQuery('.item-count').html();
        jQuery('.cart-totals span').html(cartcount);
        jQuery('.single_add_to_cart_button').removeClass('adding-cart');
        jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
        jQuery('.cart-dropdown').addClass('show-dropdown');
                setTimeout(function () { 
                    jQuery('.cart-dropdown').removeClass('show-dropdown');
                }, 3000);
      }
    });
  }
});
/*<!--Video Modal--> */

    $(document).ready(function() {
  
// Support for AJAX loaded modal window.
// Focuses on first input textbox after it loads the window.
$('.btndiv [data-toggle="modal"]').click(function(e) {
  e.preventDefault();
  $('#productmoreinfo_popup').html('');
  $(".loader").show();
  var pid = $(this).data('pid');
  var currency = $(this).data('currency');
  var tabtype = $(this).attr('tabtype');
      //alert(ajaxurl);
  if (pid) {

        $.ajax({
            type:'POST',
            url:ajaxurl,
            //data:'contactFrmSubmit=1&name='+name+'&email='+email+'&message='+message,
            data:'moreinfoFrmSubmit=1&pid='+pid+'&tabtype='+tabtype+'&currency='+currency,
            beforeSend: function (data) {
                //$('.submitBtn').attr("disabled","disabled");
                $(".more-info").modal('show');
                //$('#productmoreinfo_popup').css('opacity', '.5');
               // $('#productmoreinfo_popup').html('');
            },
            success:function(responce){
              $(".loader").hide();
              $("#productmoreinfo_popup").html(responce);
               //$('#productmoreinfo_popup').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
            }
        });    
        
     }
  
    });
/*<!-- menus script -->*/


  /**
   * Slide bottom instantiation and action.
   */
  var slideBottom = new Menu({
    wrapper: '#o-wrapper',
    type: 'slide-bottom',
    menuOpenerClass: '.c-button',
    maskId: '#c-mask'
  });

  //var slideBottomBtn = document.querySelector('#c-button--slide-bottom');
  var slideBottomBtn = document.querySelector('.c-button--slide-bottom');
  
 /* slideBottomBtn.addEventListener('click', function(e) {
    e.preventDefault;

    slideBottom.open();
  });*/
  jQuery('.cbuttonslidebottom').click(function(){
  	//alert(00);
    $('#c-menu--slide-bottom #preordersection').html('');
    $(".loader").show();
    var pid = $(this).data('pid');
    var currency = $(this).data('currency');

      $.ajax({
            type:'POST',
            url:ajaxurl,
            //data:'contactFrmSubmit=1&name='+name+'&email='+email+'&message='+message,
            data:'preorderFrmSubmit=1&pid='+pid+'&currency='+currency,
            beforeSend: function (data) {
                //$('.submitBtn').attr("disabled","disabled");
                slideBottom.open();
                //$('#productmoreinfo_popup').css('opacity', '.5');
                //$('#c-menu--slide-bottom #preordersection').html('');
            },
            success:function(responce){
              $(".loader").hide();
              $("#c-menu--slide-bottom #preordersection").html(responce);
               //$('#productmoreinfo_popup').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
               
            }
        });
  });



jQuery('#productmoreinfo_popup').delegate('.cbuttonslidebottom','click',function(){
    //alert(00);
   jQuery(".modal-backdrop").remove();
   jQuery(".more-info").hide();
    $('#c-menu--slide-bottom #preordersection').html('');
    $(".loader").show();
    var pid = $(this).data('pid');
    var currency = $(this).data('currency');

      $.ajax({
            type:'POST',
            url:ajaxurl,
            //data:'contactFrmSubmit=1&name='+name+'&email='+email+'&message='+message,
            data:'preorderFrmSubmit=1&pid='+pid+'&currency='+currency,
            beforeSend: function (data) {
                //$('.submitBtn').attr("disabled","disabled");
                slideBottom.open();
                //$('#productmoreinfo_popup').css('opacity', '.5');
                //$('#c-menu--slide-bottom #preordersection').html('');
            },
            success:function(responce){
              $(".loader").hide();
              $("#c-menu--slide-bottom #preordersection").html(responce);
               //$('#productmoreinfo_popup').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
               
            }
        });
  });


});