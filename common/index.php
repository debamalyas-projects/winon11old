<?php
include('common/include.php');

check_logout();

$header = file_get_contents('templates/contents/common/header.html');
$login = file_get_contents('templates/contents/home.html');
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
				'*{register_link}*' => 'register.php',
				'*{terms_link}*'=>'terms.php',
				'*{privacy_link}*'=>'privacy.php',
				'*{firstName}*'=>'',
				'*{lastName}*'=>$last_name,
				'*{email}*'=>$email,
				'*{phone}*'=>$phone,
				'*{message}*'=>$message,
				'*{msg}*'=>$_SESSION['subsMsg'],
				'*{alert-msg}*'=>$msg,
				'*{active_status}*'=>'active',
				'*{BASE_URL}*' => BASE_URL
				);
$content = replace_tags_html($tags_arr,$content);

echo $content;

