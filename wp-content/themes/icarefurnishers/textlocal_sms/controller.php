<?php
session_start();
error_reporting(E_ALL & ~ E_NOTICE);
require ('textlocal.class.php');

class Controller
{
    function __construct() {
        $this->processMobileVerification();
    }
    function processMobileVerification()
    {
        switch ($_POST["action"]) {
            case "send_otp":
                
                $mobile_number = trim($_POST['mobile_number']);
                $email_id = trim($_POST['email_id']);
                $email_idarr = explode("@", $email_id);
                
                $username = "info@icarefurnishers.com";
                $hash = "e8320ca87aef8c2475d2d940d88f4854c13962600f962e3104fc1cf443b23c10";
                $apiKey = urlencode('1Zilr7YwMkg-6IeKWxhi1ldsGmf8MAdPZvW4G4o0Lc');
                $Textlocal = new Textlocal(false, false, $apiKey);
                //$Textlocal = new Textlocal('info@icarefurnishers.com', 'Ss@202923');
                                
                $numbers = array($mobile_number);
                $sender = 'ICRFUR';
                $otp = rand(100000, 999999);
                $_SESSION['session_otp'] = $otp;
                //$message = "Your One Time Password is " ;
                $message = "Verification code for user ".$email_idarr[0]." registration ".$otp.".%nThis code is valid for 3 min and uses only for your identity verification purpose.";
                $headers = "From: info@icarefurnishers.com" . "\r\n";

                //===============================Send Email
                //---------------Mail send to Admin
                //$admin_email = get_option('admin_email');
                $subject = "Mobile Number verify otp";
                $adbody = '<p>Hello,<br/><br/>'.$message.'<br/><br/>
                Regards,<br>icarefurnishers Team</p>';
                mail( $email_id,$subject,$adbody,$headers); 
                //========================================End
                
                try{
                    $response = $Textlocal->sendSms($numbers, $message, $sender);
                    //require_once ("verification-form.php");
                    exit();
                }catch(Exception $e){
                    die('Error: '.$e->getMessage());
                }
                break;
                
            case "verify_otp":
                $otp = $_POST['otp'];
                
                if ($otp == $_SESSION['session_otp']) {
                    unset($_SESSION['session_otp']);
                    echo json_encode(array("type"=>"success", "message"=>"Your mobile number is verified!", "code"=>"ok"));
                } else {
                    echo json_encode(array("type"=>"error", "message"=>"Mobile number verification failed", "code"=>"no"));
                }
                break;
        }
    }
}
$controller = new Controller();
?>