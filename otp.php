<?php
include('common/include.php');

check_logout();

$header = file_get_contents('templates/register/common/header.html');
$login = file_get_contents('templates/register/otp.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content = $header.$login.$footer;

/*Common html replacements*/
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => '',
				'*{register_active}*' => '',
				'*{otp_active}*' => 'active',
				'*{login_link}*' => 'login.php',
				'*{register_link}*' => 'register.php',
				'*{ForgotPassword_link}*' => 'ForgotPassword.php',
				'*{otp_link}*' => 'javascript:void(0);',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

$message = '';

if(isset($_POST['submit'])){
	$otp = $_POST['otp'];
	
	if($otp==''){
		$message = '<div style="color:red;">Enter your OTP received in your mobile number.</div>';
	}else{
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('MobileOTP'=>$otp);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		if(count($result_array['data'])==0){
			$message = '<div style="color:red;">Invalid OTP or OTP expired.</div>';
		}else{
			$request = array();
			$request['tableName'] = 'customers';
			$request['fields_to_be_updated'] = array('MobileOTP'=>'');
			$request['fields'] = array('ID'=>$result_array['data'][0]['ID']);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			
			$_SESSION['customer']['id'] = $result_array['data'][0]['ID'];
			$_SESSION['customer']['email'] = $result_array['data'][0]['EmailAddress'];
			$_SESSION['customer']['firstName'] = $result_array['data'][0]['FirstName'];
			$_SESSION['customer']['lastName'] = $result_array['data'][0]['LastName'];
			header('location:dashboard.php');
		}
	}
}

$tags_arr=array(
				'*{alert-msg}*' => $message
				);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;