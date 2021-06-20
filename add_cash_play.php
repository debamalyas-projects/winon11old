<?php
include('common/include.php');
include('thirdParty/aadharintigration/aadhar.php');

check_login();

$id=$_SESSION['customer']['id'];

	
$header = file_get_contents('templates/account/common/header.html');
$claim_cash_form = file_get_contents('templates/account/add_cash_play_form.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$claim_cash_form.$footer;
$message = '';
$transfer = '';
$tags_arr=array(
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{My_Account_Link}*' => 'myAccount.php',
			'*{BASE_URL}*' => BASE_URL,
			'*{My_Dashboard_Link}*' => 'dashboard.php',
			'*{Game_Link}*' => 'game.php',
			'*{Logout_Link}*' => 'logout.php'
			);
$content = replace_tags_html($tags_arr,$content);

$request = array();
$request['query'] = "SELECT * FROM `customers` WHERE `ID`= '".$id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

//Data insert into claim_amount table
if(isset($_POST['submit'])){
	$transfer= $_POST['transfer'];
	
	if($transfer=='' || $transfer==0){
		$message = '<div style="color:red;">Transfer balance must be greater than 0.</div>'.'<br>';
	}else if($transfer>$result_array['data'][0]['win_amount']){
		$message = '<div style="color:red;">Transfer balance must be smaller or equal to Win balance.</div>'.'<br>';
	}
	else{
		$balance = $result_array['data'][0]['win_amount']-$transfer;
		$amount = $result_array['data'][0]['Amount']+$transfer;
		
		$request = array();
		$request['query'] = "UPDATE `customers` SET `win_amount`='".$balance."', `amount`='".$amount."' WHERE `ID`='".$id."'";

		$request_json = json_encode($request);

		$api = API_URL.'dml_query';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 

		$message = '<div style="color:green;">Amount added for playing from winning amount.</div>';
	}
}
//Data insert into claim_amount table

$tags_arr=array(
			'*{alert-msg}*'=>$message,
			'*{transfer}*'=>$transfer
			);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;
?>