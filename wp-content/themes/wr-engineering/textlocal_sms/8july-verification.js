jQuery('body').delegate('#mobile','click',function(e) 
{
  e.preventDefault();

  jQuery(".merror").html("").hide();
	var number = jQuery("#phoneno").val();
	if (number.length == 10 && number != null) {
		var input = {
			"mobile_number" : number,
			"action" : "send_otp"
		};
		jQuery.ajax({
			url : 'controller.php',
			type : 'POST',
			data : input,
			success : function(response) {
				jQuery(".mcontainer").html(response);
			}
		});
	} else {
		$(".merror").html('Please enter a valid number!')
		$(".merror").show();
	}

});

jQuery("#verifyotpshow").hide();
function sendOTP() {
	jQuery(".merror").html("").hide();
	var user_email = jQuery("#user_email").val();
	var number = jQuery("#phoneno").val();
	if (number.length == 10 && number != null && user_email !=null) {
		var input = {
			"mobile_number" : number,
			"email_id" : user_email,
			"action" : "send_otp"
		};
		jQuery.ajax({
			url : 'wp-content/themes/icarefurnishers/textlocal_sms/controller.php',
			type : 'POST',
			data : input,
			success : function(response) {
				//console.log("---"+response);	
				jQuery(".mcontainer").html(response);
				jQuery("#verifyotpshow").show();
				jQuery("#SendVerification").hide();
				
			}
		});
	} else {
		jQuery(".merror").html('Please enter a valid number and email!')
		jQuery(".merror").show();
	}
}

function verifyOTP() {
	jQuery(".merror").html("").hide();
	jQuery(".mcontainer").html("").hide();
	var otp = jQuery("#mobileOtp").val();
	alert(otp);
	var input = {
		"otp" : otp,
		"action" : "verify_otp"
	};
	if (otp.length == 6 && otp != null) {
		jQuery.ajax({
			url : 'wp-content/themes/icarefurnishers/textlocal_sms/controller.php',
			type : 'POST',
			dataType : "json",
			data : input,
			success : function(response) {
				jQuery(".mcontainer").html(response.message)
				jQuery(".mcontainer").show();
				if(response.code=='ok')
				{
					jQuery("#wpum_submitVerify").hide();
					jQuery("#wpum_submit").show();
				}
			},
			error : function() {
				alert("ss");
			}
		});
	} else {
		jQuery(".merror").html('You have entered wrong OTP.')
		jQuery(".merror").show();
	}
}