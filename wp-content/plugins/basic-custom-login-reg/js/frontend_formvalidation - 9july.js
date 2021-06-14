jQuery(document).ready(function() {

    $.validator.setDefaults({
            submitHandler: function() {
                   /* var captcha = $("#g-recaptcha-response").val();
                    if(captcha==""){
                             $("#captcha_error").show().html('Please check correct captcha key.');
                             return false;
                    } else{
                            return true;
                    $("#register_form").submit();
                    //alert("submitted!");
                                
                }*/
                $("#wpumregister_form").submit();
        }
    });
      // validate signup form on keyup and submit
        $("#wpumregister_form").validate({
            rules: {
                "first_name": "required",
                "last_name":"required",
                 "user_login": {
                    required: true,
                    minlength: 6
                },
                "pass1": {
                    required: true,
                    minlength: 8
                },
                "pass2": {
                    required: true,
                    minlength: 8,
                    equalTo: "#pass1"
                },
                "user_country":{
                     required: true,
                    //minlength: 8
                },
                "user_state":{
                     required: true,
                    //minlength: 8
                },
                "user_email": {
                    required: true,
                    email: true
                },
                "user_city":{
                    required: true
                },
                "zip_code":{
                    "required":true
                },
                "agree":{
                    "required":true
                }/*,
                "CaptchaCode": { 
                    "required": true,
                    "remote": $("#CaptchaCode").get(0).Captcha.ValidationUrl
                 }*/

            },
            messages: {
                "first_name": "Please enter your first name.",
                "last_name":"Please enter your last name.",
                "user_country":"Please select country.",
                "user_login": {
                    required: "Username must consist of at least 6 characters." 
                },
                "pass1": {
                    required: "Password must be at least 8 characters long."
                },
                "pass2": {
                    required: "Please retype a password.",
                    minlength: "Your password must be at least 8 characters long.",
                    equalTo: "Please enter the same password as above."
                },
                "user_city": {
                    required: "Please enter city."
                },
                /*"CaptchaCode": {
                    required: "The Captcha code is required",
                     remote: "The Captcha code must be retyped correctly"
                  },*/
                "address" :"Please enter your address.",
                "user_state":"Please select state.",
                "zip_code": "Please enter Post Code.",
                "user_email": "Please enter a valid email address.",
                "agree":"Plese agree the term and condition."
            },
                // the Captcha input must only be validated when the whole code string is
                // typed in, not after each individual character (onkeyup must be false)
                onkeyup: false,
                // validate user input when the element loses focus
                onfocusout: function(element) { $(element).valid(); },
                // reload the Captcha image if remote validation failed
                showErrors: function(errorMap, errorList) {
                /*if (typeof(errorMap.CaptchaCode) != "undefined" &&
                errorMap.CaptchaCode === this.settings.messages.CaptchaCode.remote) {
                $("#CaptchaCode").get(0).Captcha.ReloadImage();
                }*/
                this.defaultShowErrors();
                },
        
        });

/*
*------------------------------------------------Edit Profile
*/
$.validator.setDefaults({
                submitHandler: function() 
                {
                        $("#wpum_editprofile").submit();
                }
    });
      // validate signup form on keyup and submit
        $("#wpum_editprofile").validate({
            rules: {
                "first_name": "required",
                "last_name":"required",
                 "user_login": {
                    required: true,
                    minlength: 6
                },
                "pass1": {
                    //required: true,
                    minlength: 8
                },
                /*"pass2": {
                    required: true,
                    minlength: 8,
                    equalTo: "#pass1"
                },*/
                "user_country":{
                     required: true,
                    //minlength: 8
                },
                "user_state":{
                     required: true,
                    //minlength: 8
                },
                "user_email": {
                    required: true,
                    email: true
                },
                "user_city":{
                    required: true
                },
                "zip_code":{
                    "required":true
                }

            },
            messages: {
                "first_name": "Please enter your first name.",
                "last_name":"Please enter your last name.",
                "user_country":"Please select country.",
                "user_login": {
                    required: "Username must consist of at least 6 characters." 
                },
                "pass1": {
                    required: "Password must be at least 8 characters long."
                },
                "user_city": {
                    required: "Please enter city."
                },
                "address" :"Please enter your address.",
                "user_state":"Please select state.",
                "zip_code": "Please enter Post Code.",
                "user_email": "Please enter a valid email address."
            }
        
        });

/*
*------------------------------------------------Login Form
*/
$.validator.setDefaults({
                    submitHandler: function()
                        {
                            
                            $("#wpum_login").submit();
                        }
                        
            });

        $(document).ready(function() {
              // validate signup form on keyup and submit
                $("#wpum_login").validate({
                    rules: {
                       "username": {
                            required: true,
                            minlength: 6
                        },
                        "password": {
                            required: true,
                            minlength: 8
                        }

                    },
                    messages: {
                    
                        "username": {
                            required: "Username must consist of at least 6 characters." 
                        },
                        "password": {
                            required: "Password must be at least 8 characters long."
                        }
                    }
                
                });

            });

/*-------------------------------------------------------------------------*/
  // propose username by combining first- and last_name
function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 4; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

        $("#user_login").focus(function() {
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var rand = makeid();
            if (first_name && last_name && !this.value) {
                this.value = (first_name + "." + last_name).toLowerCase();
            }
        });

    });

 jQuery(document).ready(function() {

$("#user_email").change(function(){

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
//------------------------Lost Password-------------------------------------------------

$.validator.setDefaults({
                submitHandler: function() 
                {
                    var wplostpassword_url = jQuery("#wplostpassword_url").val();

                       var user_login =  jQuery("#user_login").val();

                        jQuery.ajax({
                        type: 'POST',
                        url: wplostpassword_url,
                        data: 'user_login='+user_login,
                        success: function (response) {
                            console.log('**********'+response);
                            jQuery('.lostpassword-submit').append('<p>Please check your Email!.</p>');
                            
                             }
                        });
                }
    });
      // validate signup form on keyup and submit
        $("#lostpasswordform").validate({
            rules: {
                 "user_login": {
                    required: true,
                    email: true
                }

            },
            messages: {
           
                "user_login": {
                    required: "Enter your valid email address." 
                }
            }
        
        });

//------------------------Lost Password-------------------------------------------------

$.validator.setDefaults({
            submitHandler: function()
                {
                    
                   var wpumresetpassform_url = jQuery("#wpumresetpassform_url").val();

                   var user_logindata =  jQuery("#wpumresetpassform").serialize();

                    jQuery.ajax({
                    type: 'POST',
                    url: wpumresetpassform_url,
                    data: user_logindata,
                    success: function (response) {
                        console.log('**********'+response);
                       if(response=='Success')
                        {
                            
                            window.location.href="/login?password=changed";
                        }
                        
                        
                         }
                    });
                }
                        
            });

              // validate signup form on keyup and submit
                $("#wpumresetpassform").validate({
                    rules: {
                            "pass1": {
                                    required: true,
                                    minlength: 8
                            },
                            "pass2": {
                                required: true,
                                minlength: 8,
                                equalTo: "#pass1"
                            }
                    },
                    messages: {
                    
                                "pass1": {
                                        required: "Password must be at least 8 characters long."
                                },
                                "pass2": {
                                        required: "Please retype a password.",
                                        minlength: "Your password must be at least 8 characters long.",
                                        equalTo: "Please enter the same password as above."
                                        }
                    }
                
                });
