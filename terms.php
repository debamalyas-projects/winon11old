<?php

include('common/include.php');
if(isset($_SESSION['customer']['id'])){
	$header = file_get_contents('templates/account/common/header.html');
	$terms = file_get_contents('templates/contents/terms.html');
	$footer = file_get_contents('templates/account/common/footer.html');

	$content = $header.$terms.$footer;

	/*Common html replacements*/
	$tags_arr=array(
					'*{ASSET_LINK}*' => ASSET_LINK,
					'*{login_active}*' => 'active',
					'*{terms_active}*' => '',
					'*{privacy_active}*' => '',
					'*{login_link}*' => 'login.php',
					'*{home_page_link}*' => 'dashboard.php',
					'*{register_link}*' => 'register.php',
					'*{terms_link}*'=>'terms.php',
					'*{msg}*'=>$subsMsg,
					'*{privacy_link}*'=>'privacy.php',
					'*{BASE_URL}*' => BASE_URL
					);
}else{
	$header = file_get_contents('templates/contents/common/header.html');
	$terms = file_get_contents('templates/contents/terms.html');
	$footer = file_get_contents('templates/contents/common/footer.html');

	$content = $header.$terms.$footer;

	/*Common html replacements*/
	$tags_arr=array(
					'*{ASSET_LINK}*' => ASSET_LINK,
					'*{login_active}*' => 'active',
					'*{terms_active}*' => '',
					'*{privacy_active}*' => '',
					'*{login_link}*' => 'login.php',
					'*{home_page_link}*' => 'index.php',
					'*{register_link}*' => 'register.php',
					'*{terms_link}*'=>'terms.php',
					'*{privacy_link}*'=>'privacy.php',
					'*{msg}*'=>$subsMsg,
					'*{BASE_URL}*' => BASE_URL
					);
}
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;