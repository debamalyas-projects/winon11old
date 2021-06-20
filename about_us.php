<?php

include('common/include.php');
if(isset($_SESSION['customer']['id'])){
	$header = file_get_contents('templates/account/common/header.html');
	$login = file_get_contents('templates/contents/about_us.html');
	$footer = file_get_contents('templates/account/common/footer.html');

	$content = $header.$login.$footer;
	$tags_arr=array(
		'*{ASSET_LINK}*' => ASSET_LINK,
		'*{login_active}*' => 'active',
		'*{terms_active}*' => '',
		'*{privacy_active}*' => '',
		'*{home_page_link}*' => 'dashboard.php',
		'*{login_link}*' => 'login.php',
		'*{register_link}*' => 'register.php',
		'*{terms_link}*'=>'terms.php',
		'*{privacy_link}*'=>'privacy.php',
		'*{firstName}*'=>'',
		'*{lastName}*'=>$last_name,
		'*{email}*'=>$email,
		'*{phone}*'=>$phone,
		'*{message}*'=>$message,
		'*{msg}*'=>$subsMsg,
		'*{alert-msg}*'=>$msg,
		'*{active_status_about}*'=>'active',
		'*{BASE_URL}*' => BASE_URL
		);
}else{
	$header = file_get_contents('templates/contents/common/header.html');
	$login = file_get_contents('templates/contents/about_us.html');
	$footer = file_get_contents('templates/contents/common/footer.html');

	$content = $header.$login.$footer;
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
		'*{msg}*'=>$subsMsg,
		'*{alert-msg}*'=>$msg,
		'*{active_status_about}*'=>'active',
		'*{BASE_URL}*' => BASE_URL
		);
}
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);	
echo $content;
?>