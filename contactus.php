<?php
include('common/include.php');

$header = file_get_contents('templates/contents/common/header.html');
$login = file_get_contents('templates/contents/contact.html');
$footer = file_get_contents('templates/contents/common/footer.html');

$content = $header.$login.$footer;

/*Common html replacements*/
$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{login_active}*' => 'active',
				'*{terms_active}*' => '',
				'*{privacy_active}*' => '',
				'*{home_page_link}*' => 'index.php',
				'*{login_link}*' => 'login.php',
				'*{ForgotPassword}*' => 'ForgotPassword.php',
				'*{contactus}*' => 'contactus.php',
				'*{register_link}*' => 'register.php',
				'*{terms_link}*'=>'terms.php',
				'*{privacy_link}*'=>'privacy.php',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

