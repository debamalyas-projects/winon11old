<?php
include('common/include.php');

check_login();

$contest_id = $_POST['contest_id'];
$team_id = $_POST['team_id'];
$customer_id = $_POST['customer_id'];

$team_name_template = file_get_contents('templates/account/team_name.html');

$team_score_template = file_get_contents('templates/account/team_score.html');

$request = array();
$request['query'] = "SELECT * FROM `rank`,`customers` WHERE `rank`.`CustomerID`=`customers`.`ID` AND `rank`.`ContestID`='".$contest_id."' AND `rank`.`CustomerID`='".$customer_id."' AND `rank`.`Status`='1' AND `rank`.`TeamID`='".$team_id."'";

$request_json = json_encode($request);


$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$team_name = $result_array['data'][0]['FirstName'].'-'.'team'.$result_array['data'][0]['TeamID'];
$team_score = $result_array['data'][0]['Score'];

$tags_arr=array(
			'*{team_name}*' => $team_name,
			'*{ASSET_LINK}*' => ASSET_LINK
			);
$team_name_template = replace_tags_html($tags_arr,$team_name_template);

$tags_arr=array(
			'*{team_score}*' => $team_score,
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{contest_id}*' => $contest_id,
			'*{team_id}*' => $team_id,
			'*{customer_id}*' => $customer_id
			);
$team_score_template = replace_tags_html($tags_arr,$team_score_template);

$request = array();
$request['query'] = "SELECT * FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."' AND `TeamID`='".$team_id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$companies=array();
for($i=0;$i<count($result_array['data']);$i++){
	$request_com = array();
	$request_com['query'] = "SELECT * FROM `contestCompanyZonePoint` WHERE `contestId`='".$contest_id."' AND `companyId`='".$result_array['data'][$i]['CompanyID']."'";

	$request_json_com = json_encode($request_com);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json_com,$api);

	$result_com = $curl_obj->exec_curl(); 

	$result_com_array = json_decode($result_com,true);
					
	if($result_array['data'][$i]['IsPrimaryCompany']==1){
		$company_score = 2*$result_com_array['data'][0]['companyScore'];
		$com_type = 'P';
	}else{
		if($result_array['data'][$i]['IsSecondaryCompany']==1){
			$company_score = 1.5*$result_com_array['data'][0]['companyScore'];
			$com_type = 'D';
		}else{
			$company_score = $result_com_array['data'][0]['companyScore'];
			$com_type = '';
		}
	}
	
	$request_com_name = array();
	$request_com_name['query'] = "SELECT * FROM `company` WHERE `ID`='".$result_array['data'][$i]['CompanyID']."'";

	$request_json_com_name = json_encode($request_com_name);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json_com_name,$api);

	$result_com_name = $curl_obj->exec_curl(); 

	$result_com_name_array = json_decode($result_com_name,true);
	
	$company_name = $result_com_name_array['data'][0]['CompanyCode'];
	
	$companies[] = $result_array['data'][$i]['CompanyID'].'|'.$company_name.'|'.$result_com_array['data'][0]['zoneId'].'|'.$company_score.'|'.$com_type;
}

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
	$company_part_template = file_get_contents('templates/account/company_part_template_footer1.html');
	$companyListing = createCompanyListingInZone($result_array['data'][$i]['zoneId'],$companies,$company_part_template);
	$tags_arr=array(
			'*{zoneName}*' => $result_array['data'][$i]['zoneName'],
			'*{zoneId}*' => $result_array['data'][$i]['zoneId'],
			'*{companyListing}*' => $companyListing
			);
	$footer_zone_list_part = replace_tags_html($tags_arr,$footer_zone_list_part);
	$footer_zone_list = $footer_zone_list.$footer_zone_list_part;
}

echo $team_name_template.$footer_zone_list.$team_score_template;

function createCompanyListingInZone($zoneId,$company_arr,$template){
	$company_zone = '';
	for($i=0;$i<count($company_arr);$i++){
		$out = $template;
		$company_inf_arr = explode('|',$company_arr[$i]);
		$company_zoneId = $company_inf_arr[2];
		if($company_inf_arr[4]==''){
			$com_type = '';
		}else{
			$com_type = '('.$company_inf_arr[4].')';
		}
		if($zoneId==$company_zoneId){
			$tags_arr=array(
			'*{companyId}*' => $company_inf_arr[0],
			'*{companyName}*' => $company_inf_arr[1],
			'*{companyPoint}*' => $company_inf_arr[3],
			'*{com_type}*' => $com_type
			);
			$out = replace_tags_html($tags_arr,$out);
			
			$company_zone = $company_zone.$out;
		}
	}
	return $company_zone;
}
