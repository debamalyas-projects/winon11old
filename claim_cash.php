<?php
include('common/include.php');
include('thirdParty/aadharintigration/aadhar.php');

check_login();

$id=$_SESSION['customer']['id'];

	
$header = file_get_contents('templates/account/common/header.html');
$claim_cash_form = file_get_contents('templates/account/claim_cash_form.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$claim_cash_form.$footer;
$message = '';
$claim = '';
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
$request['query'] = "SELECT * FROM `customerinformation`,`customers` WHERE `customerinformation`.`CustomerID`=`customers`.`ID` AND  `customerinformation`.`CustomerID`= '".$id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$request = array();
$request['tableName'] = 'customers';
$request['fields'] = array('ID'=>$id);

$request_json = json_encode($request);

$api = API_URL.'get_entity_by_fields_from_table';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array_customer = json_decode($result,true);


$request_array = array();
		
$request_array['query'] = "SELECT * FROM `customerpancardfile` WHERE `CustomerID`='".$id."'";
	
$request_json = json_encode($request_array);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl();
$pan_image_result = json_decode($result,true);


//Data insert into claim_amount table
if(isset($_POST['claim'])){
	$claim= $_POST['claim'];
	$customer_name = $result_array['data'][0]['FirstName'].' '.$result_array['data'][0]['LastName'];

	if($result_array['data'][0]['win_amount']<500){
		$message = '<div style="color:red;">To withdraw wallet balance. Balance must be 500 or more</div>'.'<br>';
	}else if($result_array['data'][0]['win_amount']<$claim){
		$message = '<div style="color:red;">Your acount does not have sufficient balance.</div>'.'<br>';
	}else if($claim<500){
		$message = '<div style="color:red;">You cannot withdraw less than ₹500.</div>'.'<br>';
	}else if($result_array_customer['data'][0]['PanNumber']==''){
		$message = '<div style="color:red;">Pancard verfication required for claim wining amount.</div>'.'<br>';
	}else if($pan_image_result['data'][0]['PanCardFile']==''){
		$message = '<div style="color:red;">Please upload pancard image before windrow wining amount.</div>'.'<br>';
	}else if($result_array_customer['data'][0]['AadharNumber']==''){
		$message = '<div style="color:red;">Aadharcard verfication required for claim wining amount.</div>'.'<br>';
	}else{
		$request = array();
		$request['tableName'] = 'claim_amount';
		$request['fields'] = array('CustomerID'=>$id,'CustomerName'=>$customer_name,'BankAccountNumber'=>$result_array['data'][0]['CustomerBankAccountNumber'],'IFSCCode'=>$result_array['data'][0]['CustomerBankIfsc'],'BankBranch'=>$result_array['data'][0]['CustomerBankBranch'],'WiningAmountInWallet'=>$result_array['data'][0]['win_amount'],'ClaimAmount'=>$claim);
		
		$request_json = json_encode($request);
		
		
		$api = API_URL.'insert_entity_into_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		$result_array_customer_info = json_decode($result,true);
		
		$balance = $result_array['data'][0]['win_amount']-$claim;
		
		$request = array();
		$request['query'] = "UPDATE `customers` SET `win_amount`='".$balance."' WHERE `ID`='".$id."'";

		$request_json = json_encode($request);

		$api = API_URL.'dml_query';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 

		if($result_array_customer_info['message']==1){
			$message = '<div style="color:green;">Your withdrawl is under process. It will be in your account in 48 hrs.</div>';
		}else{
			$message = '<div style="color:red;">Withdrawl is unsuccessfull. Please contact the administration.</div>';
		}
	}
}
//Data insert into claim_amount table

$tags_arr=array(
			'*{bank_name}*' => $result_array['data'][0]['CustomerBankName'],
			'*{bank_branch}*' => $result_array['data'][0]['CustomerBankBranch'],
			'*{bank_account_number}*' => $result_array['data'][0]['CustomerBankAccountNumber'],
			'*{ifsc}*' => $result_array['data'][0]['CustomerBankIfsc'],
			'*{wallet}*' => $result_array['data'][0]['win_amount'],
			'*{claim}*'=>$claim,
			'*{alert-msg}*'=>$message
			);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;
?>