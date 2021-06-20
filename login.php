<?php
include('common/include.php');
include('thirdParty/FacebookLogin/config.php');

check_logout();

//Google Login
include('thirdParty/googleLogin/config.php');


$login_button = '';

$login_button = $google_client->createAuthUrl();
//Google Login

//Facebook Login

$facebook_helper = $facebook->getRedirectLoginHelper();

// Get login url
$facebook_permissions = ['email']; // Optional permissions

$facebook_login_url = $facebook_helper->getLoginUrl(FB_REDIRECT_URI, $facebook_permissions);

//Facebook Login

$header = file_get_contents('templates/register/common/header.html');
$login = file_get_contents('templates/register/login.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content = $header.$login.$footer;

/*Common html replacements*/
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => 'active',
				'*{register_active}*' => '',
				'*{otp_active}*' => '',
				'*{login_link}*' => 'login.php',
				'*{home_page_link}*' => 'home.php',
				'*{register_link}*' => 'register.php',
				'*{ForgotPassword_link}*' => 'ForgotPassword.php',
				'*{otp_link}*' => 'javascript:void(0);',
				'*{msg}*'=>$_SESSION['msg'],
				'*{FB-LOGIN}*' => $facebook_login_url,
				'*{GOOGLE_LOGIN}*' => $login_button,
				'*{active_status_login}*'=>'active',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

$message = '';
$message_otp = '';

if(isset($_POST['general_login'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else if($password==''){
		$message = '<div style="color:red;">Enter password.</div>';
	}else{
		$request['request'] = array ( 
		'userId' => $email,
		'password' => $password
		);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'login';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		
		$result_array = json_decode($result);
		
		if($result_array->message=='Login successful.'){
			$_SESSION['customer']['id'] = $result_array->data->userId;
			header('location:dashboard.php');
		}else{
			$message = '<div style="color:red;">'.$result_array->message.'</div>';
		}
	}
}else if(isset($_POST['otp_login'])){
	$mobile = $_POST['mobile'];
	
	$request = array();
	$request['tableName'] = 'customers';
	$request['fields'] = array('MobileNumber'=>$mobile);

	$request_json = json_encode($request);

	$api = API_URL.'get_entity_by_fields_from_table';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	if($mobile == ''){
		$message_otp = '<div style="color:red;">Enter your mobile number.</div>';
	}else if(count($result_array['data'])==0){
		$message_otp = '<div style="color:red;">Mobile number doesn\'t exist.</div>';
	}else if($result_array['data'][0]['Status']==0){
		$message_otp = '<div style="color:red;">Your account is inactive.</div>';
	}else{
		$MobileOTP = time();
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields_to_be_updated'] = array('MobileOTP'=>$MobileOTP);
		$request['fields'] = array('ID'=>$result_array['data'][0]['ID']);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'update_entity_fields_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		if($result_array['message']==1){
			$smsParams = array();
			$smsParams['sender'] = 'TXTLCL';
			$smsParams['numbers'] = array($mobile);
			$smsParams['message'] = 'Your OTP for account verification : '.$MobileOTP.' . OTP is valid for 180 seconds. Thanks - WinOn11 .';

			$smsObj = new sms($smsParams);

			$return=$smsObj->sendSMS();
			
			header('location:otp.php');
		}else{
			$message_otp='<div style="color:red;">Server API failed. Please contact WinOn11 Admin.</div>';
		}
	}
}

$tags_arr=array(
				'*{alert-msg}*' => $message,
				'*{alert-msg-otp}*' => $message_otp
				);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

