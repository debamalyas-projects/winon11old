<?php
include('common/include.php');
check_login();
$id=$_SESSION['customer']['id'];
$message='';

$header = file_get_contents('templates/account/common/header.html');
$account_otp_form = file_get_contents('templates/account/account_otp_form.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$account_otp_form.$footer;

$tags_arr=array(
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{My_Account_Link}*' => 'myAccount.php',
			'*{BASE_URL}*' => BASE_URL,
			'*{My_Dashboard_Link}*' => 'dashboard.php',
			'*{Game_Link}*' => 'game.php',
			'*{Logout_Link}*' => 'logout.php'
			);
$content = replace_tags_html($tags_arr,$content);

if(isset($_POST['submit_otp'])){
	$otp=$_POST['otp'];
	if($otp==''){
		$message='<div style="color:red;">Enter your OTP received in your mobile number.</div>';
	}else{
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('ID'=>$id);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		if($otp!=$result_array['data'][0]['MobileVerificationCode']){
			$message = '<div style="color:red;">Invalid OTP or OTP expired.</div>';
		}else{
			$request = array();
			$request['tableName'] = 'customers';
			$request['fields_to_be_updated'] = array('MobileVerificationStatus'=>1,'MobileVerificationCode'=>'');
			$request['fields'] = array('ID'=>$id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			
			$result_array_customer = json_decode($result,true);
			
			$_SESSION['MobileVerificationStatus']=$result_array_customer['message'];
			header('location:myAccount.php');
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
?>