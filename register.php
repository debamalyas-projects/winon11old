<?php
include('common/include.php');

check_logout();

$header = file_get_contents('templates/register/common/header.html');
$register_form = file_get_contents('templates/register/register_form.html');
$footer = file_get_contents('templates/register/common/footer.html');

$content = $header.$register_form.$footer;

/*Common html replacements*/
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => '',
				'*{register_active}*' => 'active',
				'*{otp_active}*' => '',
				'*{login_link}*' => 'login.php',
				'*{home_page_link}*' => 'home.php',
				'*{register_link}*' => 'register.php',
				'*{msg}*'=>$_SESSION['msg'],
				'*{otp_link}*' => 'javascript:void(0);',
				'*{active_status_register}*'=>'active',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

if(isset($_POST['register'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	
	if($firstName==''){
		$message = '<div style="color:red;">Enter your first name.</div>';
	}else if($lastName==''){
		$message = '<div style="color:red;">Enter your last name.</div>';
	}else if($mobile==''){
		$message = '<div style="color:red;">Enter your mobile number.</div>';
	}else if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else if($password==''){
		$message = '<div style="color:red;">Enter password.</div>';
	}else if($confirm_password==''){
		$message = '<div style="color:red;">Enter confirm password.</div>';
	}else if($confirm_password!=$password){
		$message = '<div style="color:red;">Password and confirm password should match.</div>';
	}else{
		$request['request'] = array ( 
		'firstName' => $firstName, 
		'lastName' => $lastName, 
		'mobile' => $mobile,
		'email' => $email,
		'password' => $password
		);
		
		$request_json = json_encode($request);

		$api = API_URL.'new_register';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		
		$result_array = json_decode($result);
		
		if($result_array->message=='User is successfully registered.'){
			$message = '<div style="color:green;">You are successfully registered.</div>';
			
			$firstName = '';
			$lastName = '';
			$mobile = '';
			$email = '';
			$pan = '';
			$aadhar = '';
			$password = '';
			$confirm_password = '';
		}else{
			$message = '<div style="color:blue;">You are already registered with us.</div>';
		}
		
	}
}else{
	$message = '';
	$firstName = '';
	$lastName = '';
	$mobile = '';
	$email = '';
	$password = '';
	$confirm_password = '';
}

$content = str_replace('*{alert-msg}*',$message,$content);

/*Form Fields Value*/
$tags_arr = array(
				'*{firstName}*'=>$firstName,
				'*{lastName}*'=>$lastName,
				'*{mobile}*'=>$mobile,
				'*{email}*'=>$email,
				'*{password}*'=>$password,
				'*{confirm_password}*'=>$confirm_password
				);  
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;
