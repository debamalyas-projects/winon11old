<?php
include('common/include.php');

check_login();

$Id=$_SESSION['customer']['id'];
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/dashboard.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$dashboard.$footer;

$tags_arr=array(
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{My_Account_Link}*' => 'myAccount.php',
			'*{dashboard_link}*'=> 'dashboard.php',
			'*{BASE_URL}*' => BASE_URL,
			'*{My_Dashboard_Link}*' => 'dashboard.php',
			'*{msg}*'=>$_SESSION['msg'],
			'*{Game_Link}*' => 'game.php',
			'*{active_status}*'=>'active',
			'*{Logout_Link}*' => 'logout.php'
			);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

?>