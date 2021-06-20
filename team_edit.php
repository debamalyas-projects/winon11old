<?php
include('common/include.php');

check_login();

if(isset($_POST['creation'])){
	$platinum = $_POST['platinum'];
	$diamond = $_POST['diamond'];
	$companies = $_SESSION['company'];
	$customer_id = $_SESSION['customer']['id'];
	$contest_id = $_POST['contest_id'];
	$team_id = $_POST['team_id'];
	
	$request = array();
	$request['query'] = "SELECT * FROM `contests` WHERE `ID`='".$contest_id."'";

	$request_json = json_encode($request);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);

	$closingStatus = $result_array['data'][0]['ClosingStatus'];

	if($closingStatus!=1){
		header('location:game.php');
		die();
	}
	
	$team_exist = check_formation($platinum,$diamond,$companies,$customer_id,$contest_id,$team_id);
	if($team_exist>0){
		header('location:game_edit_team.php?contest_id='.$contest_id.'&team_id='.$team_id);
		$_SESSION['team_exist'] = 'Team already exist.';
		die();
	}
	
	//Previous Delete
	$request = array();
	$request['query'] = "DELETE FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."' AND `TeamID`='".$team_id."'";

	$request_json = json_encode($request);

	$api = API_URL.'delete_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 
	
	//Previous Delete
	
	$new_team_number = $team_id;
	
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
	header('location:game.php');
}

function check_formation($platinum,$diamond,$companies,$customer_id,$contest_id,$team_id){
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
		if($i!=$team_id){
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
	}
	
	return $team_true;
}