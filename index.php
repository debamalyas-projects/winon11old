<?php
include('common/include.php');

check_logout();

$header = file_get_contents('templates/contents/common/header.html');
$login = file_get_contents('templates/contents/home.html');
$footer = file_get_contents('templates/contents/common/footer.html');

$content = $header.$login.$footer;

$msg='';

/*Common html replacements*/
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => 'active',
				'*{terms_active}*' => '',
				'*{privacy_active}*' => '',
				'*{home_page_link}*' => 'index.php',
				'*{login_link}*' => 'login.php',
				'*{register_link}*' => 'register.php',
				'*{terms_link}*'=>'terms.php',
				'*{privacy_link}*'=>'privacy.php',
				'*{firstName}*'=>'',
				'*{lastName}*'=>$last_name,
				'*{email}*'=>$email,
				'*{phone}*'=>$phone,
				'*{message}*'=>$message,
				'*{msg}*'=>$_SESSION['subsMsg'],
				'*{active_status}*'=>'active',
				'*{BASE_URL}*' => BASE_URL
				);
				
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
if(isset($_POST['submit'])){
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if($first_name==''){
        $msg = '<div style="color:red;">First Name can not be blank.</div>';
    }else if($last_name==''){
        $msg = '<div style="color:red;">Last Name can not be blank.</div>';
    }else if($email==''){
        $msg = '<div style="color:red;">Email can not be blank.</div>';
    }else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $msg = '<div style="color:red;">Your Email is not valid. Please provide a valid email.</div>';
    }else if($phone==''){
        $msg = '<div style="color:red;">Contact number can not be blank.</div>';
    }else if(!(is_numeric($phone))){
        $msg ='<div style="color:red;">Contact number contain only numeric value.</div>';
    }elseif(strlen($phone)!=10){
        $msg = '<div style="color:red;">Contact number contain ten digits only.</div>';
    }else if($message==''){
        $msg = '<div style="color:red;">Message can not be blank.</div>';
    }else{
        $request = array();
        $request['tableName'] = 'contact_us_data';
        $request['fields'] = array('first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'contact_number'=>$phone,'message'=>$message);
        
        $request_json = json_encode($request);
        
        
        $api = API_URL.'insert_entity_into_table';
    
        $curl_obj = new curl($request_json,$api);
    
        $result = $curl_obj->exec_curl();
        $result_array_customer_info = json_decode($result,true);
        if($result_array_customer_info['message']==1){
            $msg = '<div style="color:green;">Your message has been sent sucessfuly to the admin.</div>';
        }else{
            $msg = '<div style="color:red;">Failed to sent the message.</div>';
        }


        $email_template = file_get_contents('templates/contents/contactEmailTemplate.html');
			$first_name = $first_name.' '.$last_name;
			$tags_email_arr=array(
                    '*{first_name}*' =>$first_name,
                    '*{email}*' =>$email,
                    '*{contact_number}*' =>$phone,
                    '*{message}*' =>$message
					);
			$email_template = replace_tags_html($tags_email_arr,$email_template);
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <'.$email.'>' . "\r\n";
            
			mail('winon11.contactus@gmail.com','User enquery email',$email_template,$headers);
    }
	
	
	$first_name = '';
    $last_name = '';
    $email = '';
    $phone = '';
    $message = '';
}
$tags_arr=array(
    '*{firstName}*'=>$first_name,
    '*{lastName}*'=>$last_name,
    '*{email}*'=>$email,
    '*{phone}*'=>$phone,
    '*{message}*'=>$message,
    '*{alert-msg}*'=>$msg
    );
$content = replace_tags_html($tags_arr,$content);
echo $content;

