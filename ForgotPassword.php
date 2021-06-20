<?php
include("common/include.php");

check_logout();

$header=file_get_contents('templates/register/common/header.html');
$ForgotPassword = file_get_contents('templates/register/ForgotPassword.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content=$header.$ForgotPassword.$footer;

//Common html replacements
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => '',
				'*{register_active}*' => '',
				'*{otp_active}*' => '',
				'*{login_link}*' => 'login.php',
				'*{register_link}*' => 'register.php',
				'*{ForgotPassword_link}*' => 'ForgotPassword.php',
				'*{otp_link}*' => 'javascript:void(0);',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

if(isset($_POST["submit"])){
	$email=$_POST['email'];
	
	if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else{
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('EmailAddress'=>$email);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		if($result_array['data'][0]['Status']==0){
			$message = '<div style="color:red;">Your email address is inactive.</div>';
		}else{
			
			$id = $result_array['data'][0]['ID'];
			$PasswordChangeToken = time();
			$request = array();
			$request['tableName'] = 'customers';
			$request['fields_to_be_updated'] = array('PasswordChangeToken'=>$PasswordChangeToken);
			$request['fields'] = array('ID'=>$id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			
			//$recipient_arr = array();
			//$recipient_arr[]=array('address'=>$email,'name'=>$result_array['data'][0]['FirstName'].' '.$result_array['data'][0]['LastName']);
			
			$email_template = file_get_contents('templates/register/ForgotPasswordMailTemplate.html');
			
			$tags_email_arr=array(
					'*{NAME}*' => $result_array['data'][0]['FirstName'].' '.$result_array['data'][0]['LastName'],
					'*{LINK}*' => '<a href="'.BASE_URL.'ForgotPasswordUpdate.php?token='.$PasswordChangeToken.'">Update Password LINK</a>'
					);
			$email_template = replace_tags_html($tags_email_arr,$email_template);
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <admin@zero2crore.com>' . "\r\n";
			
			mail($email,'Forget password email from Zero2crore',$email_template,$headers);
 
            $message ='<div style="color:green;">Forget password link has been sent to your Email. Please check spam mails also.</div>';

			/*$mailParams = array(
						'mailSystemArr_json'=>mailSystemArr_json,
						'recipient_arr'=>$recipient_arr,
						'replyto_arr'=>array(),
						'cc_arr'=>array(),
						'bcc_arr'=>array(),
						'attachment_arr'=>array(),
						'SetFromAddress'=>CLIENT_EMAIL,
						'SetFromName'=>CLIENT_NAME,
						'subject'=>'Forgot Password Email',
						'content'=>$email_template
						);
			
			$mailObj = new mailer($mailParams);

			$return=$mailObj->sendMailer();

			if($return==1){
				$message ='<div style="color:green;">Password Reset Link has been sent to your Email.</div>';
			}else{
				$message = '<div style="color:red;">Failed to connect to Server. </div>';
			}*/
		}		
	}
}else{
$message="";
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