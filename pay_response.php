<?php
include('common/include.php');

check_login();

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="yIEkykqEH3";
		 
       if ($status != 'success') {
	       $_SESSION['payu_message'] = "<span style='color: red;'>Invalid Transaction. Please try again</span>";
		   header('location:myAccount.php');
		   }
	   else {
		$new_amount=$amount;
		
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('ID'=>$_SESSION['customer']['id']);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);
		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		$prev_amount = $result_array['data'][0]['Amount'];
		
		if($prev_amount==''){
			$prev_amount=0;
		}
		
		$total_amount = $new_amount+$prev_amount;
		   
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields_to_be_updated'] = array('Amount'=>$total_amount);
		$request['fields'] = array('ID'=>$_SESSION['customer']['id']);
		$request_json = json_encode($request);
		
		$api = API_URL.'update_entity_fields_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		$result_array = json_decode($result,true);
           	   
          $_SESSION['payu_message'] = "<span style='color: green;'>Thank You. Your order status is '". $status ."'.<br>"."Your Transaction ID for this transaction is '".$txnid."'.<br>"."We have received a payment of Rs. '" . $amount . "'.</span>";
           header('location:myAccount.php');
		   }