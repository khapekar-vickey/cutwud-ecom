<!DOCTYPE html>
<html>
<head>
<title>How to Implement OTP SMS Mobile Verification in PHP with TextLocal</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>

	<div class="mcontainer">
		<div class="merror"></div>
		<form id="frm-mobile-verification">
			<div class="form-heading">Mobile Number Verification</div>

			<div class="form-row">
				<input type="number" id="phoneno" class="form-input"
					placeholder="Enter the 10 digit mobile">
			</div>

			<input type="button" class="btnSubmit" value="Send OTP"
				onClick="sendOTP();">
		</form>
	</div>

	<script src="jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="verification.js"></script>
</body>
</html>
<?php
require ('textlocal.class.php');
	// Account details
	$apiKey = urlencode('1Zilr7YwMkg-w0iM0XOleezcw9v4OHKd8uKxFajHYG');
 
	// Message details
    //$numbers = 447123456789 .",". 447987654321;
    $numbers = 7798396503;
	$sender = 9270876504;
	$otp = rand(100000, 999999);
	$message = 'This is your message otp ' .$otp;
	$url = 'https://api.txtlocal.com/image-logo.png';
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, 'message' => $message, 'url' => $url);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.txtlocal.com/send_mms/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
 
	// Process your response here
	echo $response;
?>