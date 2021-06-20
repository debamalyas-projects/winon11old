<?php
include('common/include.php');

check_login();

if(isset($_POST['creation'])){
	$platinum = $_POST['platinum'];
	$diamond = $_POST['diamond'];
	$companies = $_SESSION['company'];
	$customer_id = $_SESSION['customer']['id'];
	$contest_id = $_POST['contest_id'];
	
	$request = array();
	$request['query'] = "SELECT * FROM `contests` WHERE `ID`='".$contest_id."'";

	$request_json = json_encode($request);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);

	$closingStatus = $result_array['data'][0]['ClosingStatus'];
	$contestSpotsAvailable = $result_array['data'][0]['ContestSpotsAvailable'];

	if($closingStatus!=1){
		header('location:game.php');
		die();
	}
	
	if($contestSpotsAvailable==0){
		header('location:game.php');
		die();
	}
	
	$team_exist = check_formation($platinum,$diamond,$companies,$customer_id,$contest_id);
	if($team_exist>0){
		header('location:game_create_team.php?contest_id='.$contest_id);
		$_SESSION['team_exist'] = 'Team already exist.';
		die();
	}
	$request = array();
	$request['tableName'] = 'customers';
	$request['fields'] = array('ID'=>$customer_id);

	$request_json = json_encode($request);

	$api = API_URL.'get_entity_by_fields_from_table';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$amount_in_wallet = $result_array['data'][0]['Amount'];
	
	$request = array();
	$request['tableName'] = 'contests';
	$request['fields'] = array('ID'=>$contest_id);

	$request_json = json_encode($request);

	$api = API_URL.'get_entity_by_fields_from_table';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$contest_entry_fee = $result_array['data'][0]['ContestEntryFees'];
	$ContestSpotsAvailable = $result_array['data'][0]['ContestSpotsAvailable'];
	$ContestSpotsJoined = $result_array['data'][0]['ContestSpotsJoined'];
	
	if($amount_in_wallet>=$contest_entry_fee){
			//entry fee deduction from wallet , total spots rectifiy , total joined rectify
			$ContestSpotsAvailable = $ContestSpotsAvailable-1;
			if($ContestSpotsJoined==NULL){
				$ContestSpotsJoined=0;
			}
			$ContestSpotsJoined = $ContestSpotsJoined+1;
			$after_deducted_amount = $amount_in_wallet - $contest_entry_fee;
			$request = array();
			$request['tableName'] = 'customers';
			$request['fields_to_be_updated'] = array('Amount'=>$after_deducted_amount);
			$request['fields'] = array('ID'=>$customer_id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			$result_array_customer_info = json_decode($result,true);
			
			$request = array();
			$request['tableName'] = 'contests';
			$request['fields_to_be_updated'] = array('ContestSpotsAvailable'=>$ContestSpotsAvailable,'ContestSpotsJoined'=>$ContestSpotsJoined);
			$request['fields'] = array('ID'=>$contest_id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			$result_array_customer_info = json_decode($result,true);
			
			//Deducing team number_format
			$request = array();
			$request['tableName'] = 'customerteam';
			$request['fields'] = array('CustomerID'=>$customer_id,'ContestID'=>$contest_id);

			$request_json = json_encode($request);

			$api = API_URL.'get_entity_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl(); 

			$result_array = json_decode($result,true);
			
			$company_count = count($result_array['data']);
			$team_count = $company_count/11;
			
			$new_team_number = $team_count+1;
			
			//Forming company datasets for insert
			$company_arr = array();
			for($i=0;$i<count($companies);$i++){
				$company_info_arr = explode('|',$companies[$i]);
				if($platinum==$company_info_arr[0]){
					$IsPrimaryCompany = 1;
				}else{
					$IsPrimaryCompany = 0;
				}
				if($diamond==$company_info_arr[0]){
					$IsSecondaryCompany = 1;
				}else{
					$IsSecondaryCompany = 0;
				}
				$company_arr[] = array('CompanyID'=>$company_info_arr[0],'ContestID'=>$contest_id,'CustomerID'=>$customer_id,'TeamID'=>$new_team_number,'IsPrimaryCompany'=>$IsPrimaryCompany,'IsSecondaryCompany'=>$IsSecondaryCompany,'Status'=>0,'UpdatedOn'=>date("Y-m-d h:i:sa"));
			}
			
			//Inserting company datasets
			for($i=0;$i<count($company_arr);$i++){
				$request = array();
				$request['tableName'] = 'customerteam';
				$request['fields'] = $company_arr[$i];
				
				$request_json = json_encode($request);
				
				
				$api = API_URL.'insert_entity_into_table';

				$curl_obj = new curl($request_json,$api);

				$result = $curl_obj->exec_curl();
			}
			unset($_SESSION['company']);
			header('location:game_team.php?contest_id='.$contest_id);
	}else{
		echo 'Code 2';
	}
}else{
	header('location:game.php');
}

function check_formation($platinum,$diamond,$companies,$customer_id,$contest_id){
	$request = array();
	$request['tableName'] = 'customerteam';
	$request['fields'] = array('CustomerID'=>$customer_id,'ContestID'=>$contest_id);

	$request_json = json_encode($request);

	$api = API_URL.'get_entity_by_fields_from_table';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$company_count = count($result_array['data']);
	$team_count = $company_count/11;
	$team_true = 0;
	for($i=1;$i<=$team_count;$i++){
		$platinum_true = 0;
		$diamond_true = 0;
		$companies_true = 0;
		//Platinum detection
		$request = array();
		$request['tableName'] = 'customerteam';
		$request['fields'] = array('ContestID'=>$contest_id,'CustomerID'=>$customer_id,'CompanyID'=>$platinum,'IsPrimaryCompany'=>'1','TeamID'=>$i);

		$request_json = json_encode($request);

		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 

		$result_array = json_decode($result,true);
		if(count($result_array['data'])>0){
			$platinum_true = 1;
		}
		
		//Diamond detection
		$request = array();
		$request['tableName'] = 'customerteam';
		$request['fields'] = array('ContestID'=>$contest_id,'CustomerID'=>$customer_id,'CompanyID'=>$diamond,'IsSecondaryCompany'=>'1','TeamID'=>$i);

		$request_json = json_encode($request);

		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 

		$result_array = json_decode($result,true);
		if(count($result_array['data'])>0){
			$diamond_true = 1;
		}
		
		//Companies detection
		$count=0;
		for($j=0;$j<count($companies);$j++){
			$company_info_arr = explode('|',$companies[$j]);
			$request = array();
			$request['tableName'] = 'customerteam';
			$request['fields'] = array('ContestID'=>$contest_id,'CustomerID'=>$customer_id,'CompanyID'=>$company_info_arr[0],'TeamID'=>$i);

			$request_json = json_encode($request);

			$api = API_URL.'get_entity_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl(); 

			$result_array = json_decode($result,true);
			
			if(count($result_array['data'])>0){
				$count = $count+1;
			}
		}
		
		if($count==11){
			$companies_true = 1;
		}
		
		if($platinum_true == 1 && $diamond_true == 1 && $companies_true == 1){
			$team_true = $team_true+1;
		}
	}
	
	return $team_true;
}