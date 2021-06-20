<?php
include('common/include.php');

check_login();

if(isset($_POST['selection'])){
	
	$contest_id = $_POST['contest_id'];
	$companies = $_POST['company'];
	$_SESSION['company'] = $_POST['company'];
	
	$Id=$_SESSION['customer']['id'];
	
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
	}
	
	if($contestSpotsAvailable==0){
		header('location:game.php');
	}
	
	$header = file_get_contents('templates/account/common/header.html');
	$dashboard = file_get_contents('templates/account/game_create_team_platinum_diamond.html');
	$footer = file_get_contents('templates/account/common/footer_team_platinum_diamond.html');

	$content = $header.$dashboard.$footer;

	$tags_arr=array(
				'*{ASSET_LINK}*' => ASSET_LINK,
				'*{My_Account_Link}*' => 'myAccount.php',
				'*{dashboard_link}*'=> 'dashboard.php',
				'*{BASE_URL}*' => BASE_URL,
				'*{My_Dashboard_Link}*' => 'dashboard.php',
				'*{Game_Link}*' => 'game.php',
				'*{Logout_Link}*' => 'logout.php',
				'*{active_status_game}*'=>'active',
				'*{game_link}*' => 'game.php'
				);
	$content = replace_tags_html($tags_arr,$content);
	
	$request = array();
	$request['tableName'] = 'contests';
	$request['fields'] = array('ID'=>$contest_id);

	$request_json = json_encode($request);

	$api = API_URL.'get_entity_by_fields_from_table';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);

	$tags_arr=array(
				'*{ContestOpenDateTime}*' => $result_array['data'][0]['ContestOpenDateTime'],
				'*{ContestName}*' => $result_array['data'][0]['ContestName']
				);
	$content = replace_tags_html($tags_arr,$content);
	
	$content = str_replace('*{contest_id}*',$contest_id,$content);
	
	$request = array();
	$request['request'] = array('contestId'=>$contest_id);
	$request_json = json_encode($request);

	$api = API_URL.'getZonesByContestId';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$footer_zone_list = '';
	for($i=0;$i<count($result_array['data']);$i++){
		//footer zone list
		$footer_zone_list_part = file_get_contents('templates/account/footer_zone_list_p_d.html');
		$company_part_template = file_get_contents('templates/account/company_part_template_footer.html');
		$companyListing = createCompanyListingInZone($result_array['data'][$i]['zoneId'],$companies,$company_part_template);
		$tags_arr=array(
				'*{zoneName}*' => $result_array['data'][$i]['zoneName'],
				'*{zoneId}*' => $result_array['data'][$i]['zoneId'],
				'*{companyListing}*' => $companyListing
				);
		$footer_zone_list_part = replace_tags_html($tags_arr,$footer_zone_list_part);
		$footer_zone_list = $footer_zone_list.$footer_zone_list_part;
	}
	
	$companyCheckboxListing = file_get_contents('templates/account/companyCheckboxListingPart.html');
	
	$companyCheckboxListing = createCompanyListingInZone('',$companies,$companyCheckboxListing);
	
	$content = str_replace('*{companyCheckboxListing}*',$companyCheckboxListing,$content);
	
	$content = str_replace('*{footer_zone_list}*',$footer_zone_list,$content);
	
	$game_team_link = BASE_URL.'game_create_team.php?contest_id='.$contest_id;
	
	$content = str_replace('*{game_team_link}*',$game_team_link,$content);
	
	$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
    $content = replace_tags_html($tags_arr,$content);
	
	echo $content;
}else{
	header('location:game.php');
}

function createCompanyListingInZone($zoneId='',$company_arr,$template){
	if($zoneId!=''){
		$company_zone = '';
		for($i=0;$i<count($company_arr);$i++){
			$out = $template;
			$company_inf_arr = explode('|',$company_arr[$i]);
			$company_zoneId = $company_inf_arr[2];
			if($zoneId==$company_zoneId){
				$tags_arr=array(
				'*{companyId}*' => $company_inf_arr[0],
				'*{companyName}*' => $company_inf_arr[1],
				'*{companyPoint}*' => $company_inf_arr[4]
				);
				$out = replace_tags_html($tags_arr,$out);
				
				$company_zone = $company_zone.$out;
			}
		}
		return $company_zone;
	}else{
		$output = '';
		for($i=0;$i<count($company_arr);$i++){
			$out = $template;
			$company_inf_arr = explode('|',$company_arr[$i]);
			$tags_arr=array(
				'*{companyName}*' => $company_inf_arr[1],
				'*{companyId}*' => $company_inf_arr[0],
				'*{companyPlatinumValue}*' => $company_arr[$i].'|platinum',
				'*{companyDiamondValue}*' => $company_arr[$i].'|diamond'
				);
			$out = replace_tags_html($tags_arr,$out);
			
			$output = $output.$out;
		}
		return $output;
	}
}