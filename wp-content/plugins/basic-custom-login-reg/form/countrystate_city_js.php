<script type="text/javascript">
        jQuery(document).ready(function () {
            var ajaxurl =  '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery('#user_country').on('change', function () {
                //console.log('Country ' +jQuery(this).val());
                var countryID = jQuery(this).val();
                if (countryID) {
                    //var url = '<?php echo get_template_directory_uri()?>/ajaxData.php';
                    jQuery('#user_state').html();
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: 'countryID='+countryID,
                        success: function (response) {
                        	//console.log('**********'+response);
                            jQuery('#user_state').html(response);
                            jQuery('#user_city').html('<option value="">Select state first</option>');
                        }
                    });
                } else {
                    jQuery('#user_state').html('<option value="">Select country first</option>');
                    jQuery('#user_city').html('<option value="">Select state first</option>');
                }
            });

            jQuery('#user_state').on('change', function () {
                var stateID = jQuery(this).val();
               // var url = '<?php echo get_template_directory_uri()?>/ajaxData.php';
                if (stateID) {
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: 'state_id=' + stateID,
                        success: function (response) {
                            jQuery('#user_city').html(response);
                        }
                    });
                } else {
                    jQuery('#user_city').html('<option value="">Select state first</option>');
                }
            });
        });

//-------------------------------------------------------------------------



jQuery(document).ready(function() {

  // propose username by combining first- and last_name
function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 4; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

        jQuery("#user_login").focus(function() {
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var rand = makeid();
            if (first_name && last_name && !this.value) {
                this.value = (first_name + "." + last_name).toLowerCase();
            }
        });

    });

 jQuery(document).ready(function() {

jQuery("#user_email").change(function(){

        var email = $("#user_email").val();

        if(email != 0)
        {
            if(isValidEmailAddress(email))
            {
                //------------------------
              /* $.ajax({
                      type: "POST",
                      url: "<?php echo get_bloginfo('template_url');?>/ajax-files/checkeamil.php",
                    //data: $(this).serialize(),
                    data: {'emailId':email},
                    //dataType  : 'json',
                    success: function(response){
                       console.log(response);
                            
                            },
                            error: function( jqXhr, textStatus, errorThrown ){
                                console.log('***'+ textStatus, errorThrown );
                            }
             });*/
               //-----------------------------
                     return true;
            } else {
                alert('Please enter valid email!');
                return false;
            }
        } else {
           return true;      
        }

    });

});

function isValidEmailAddress(email) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(email);
}
/*-------------------------------*/

jQuery(".mulfile").change(function (e){
   $('.digi-error').hide();
   $('.reset-error').hide();
    var file = $(this).val();
    var exts = ['image/jpg','image/jpeg','image/png','application/pdf'];
     
        var files = e.originalEvent.target.files;
        for (var i=0, len=files.length; i<len; i++){
            var n = files[i].name,
                s = files[i].size,
                t = files[i].type;
            //alert(t);
            if($.inArray ( t, exts ) >-1){
                   var added = 1;
            }else{
                 var added = 0;
            }

            if (s>=300000) {
               $('.reset-error').show();
               //alert( 'Please upload file max size 30 KB only...!' );
              $('.reset-error').addClass('text-danger').html(" Please upload max file size of 300KB. (extensions allowed: jpg, jpeg ,png and pdf).");
              }else if (added==0) {
            $('.digi-error').show();
              $('.digi-error').addClass('text-danger').html("Invalid file.. only  jpg, jpeg , png and pdf extensions are allowed.!");
              //alert( 'Invalid file.. Please Try With jpg and png extensions only...!' );
            }
              else{
              //jQuery("#digisign_form").submit();
            }
        }

      
  });
//-------------------------------------------------------------------------
</script>