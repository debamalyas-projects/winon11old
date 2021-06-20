<?php
include("common/include.php");

check_logout();

$header=file_get_contents('templates/register/common/header.html');
$ForgotPasswordUpdate = file_get_contents('templates/register/ForgotPasswordUpdate.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content=$header.$ForgotPasswordUpdate.$footer;

//Common html replacements
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => '',
				'*{register_active}*' => '',
				'*{otp_active}*' => '',
				'*{otp_link}*' => 'javascript:void(0);',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

$request = array();
$request['tableName'] = 'customers';
$request['fields'] = array('PasswordChangeToken'=>$_GET['token']);

$request_json = json_encode($request);

$api = API_URL.'get_entity_by_fields_from_table';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);


if(!isset($_GET['token'])){
	echo "Page doesn't exist";
	exit();
}else if(empty($result_array['data'])) {
	echo "Page doesn't exist";
	exit();
}else{
	if(isset($_POST['submit'])){
		$password=$_POST['password'];
		$confirm_password=$_POST['confirm_password'];
		if($password==''){
			$message='<div style="color:red;">Type Your Password</div>';
		}
		else if($confirm_password==''){
			$message='<div style="color:red;">Type Your Confirm Password</div>';
		}
		else if($password!=$confirm_password){
			$message='<div style="color:red;">Password And Confirm Password Does Not Matched</div>';
		}	
		else{
				$token = $_GET['token'];
				$request = array();
				$request['tableName'] = 'customers';
				$request['fields_to_be_updated'] = array('Password'=>$password,'PasswordChangeToken'=>'');
				$request['fields'] = array('PasswordChangeToken'=>$token);
				
				$request_json = json_encode($request);
				
				$api = API_URL.'update_entity_fields_by_fields_from_table';

				$curl_obj = new curl($request_json,$api);

				$result = $curl_obj->exec_curl(); 
				
				$result_array = json_decode($result,true);

				if($result_array['message']==1){
					$message='<div style="color:green;">Password changed successfully.</div>';
				}
			}
		}
	else{
		$message="";
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