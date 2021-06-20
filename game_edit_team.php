<?php
include('common/include.php');

check_login();

if(!isset($_GET['contest_id'])){
	header('location:game.php');
}
if(!isset($_GET['team_id'])){
	header('location:game.php');
}

$contest_id = $_GET['contest_id'];

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
}

$Id=$_SESSION['customer']['id'];

$team_id = $_GET['team_id'];

$request = array();
$request['query'] = "SELECT * FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$Id."' AND `TeamID`='".$team_id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array_company = json_decode($result,true);
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/game_create_team.html');
$footer = file_get_contents('templates/account/common/footer_team.html');

$content = $header.$dashboard.$footer;

$tags_arr=array(
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{My_Account_Link}*' => 'myAccount.php',
			'*{dashboard_link}*'=> 'dashboard.php',
			'*{BASE_URL}*' => BASE_URL,
			'*{My_Dashboard_Link}*' => 'dashboard.php',
			'*{Game_Link}*' => 'game.php',
			'*{Logout_Link}*' => 'logout.php',
			'*{game_link}*' => 'game.php',
			'*{active_status_game}*'=>'active',
			'*{game_platinum_diamond_link}*' => 'game_edit_team_platinum_diamond.php'
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

$request = array();
$request['request'] = array('contestId'=>$contest_id);
$request_json = json_encode($request);

$api = API_URL.'getZonesByContestId';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$zone_tabs = '';
$zone_tab_pane = '';
$footer_zone_list = '';
$zoneids = '';
for($i=0;$i<count($result_array['data']);$i++){
	if($i==0){
		$zoneids = $result_array['data'][$i]['zoneId'];
	}else{
		$zoneids = $zoneids.'|'.$result_array['data'][$i]['zoneId'];
	}
	//footer zone list
	$footer_zone_list_part = file_get_contents('templates/account/footer_zone_list.html');
	$tags_arr=array(
			'*{zoneName}*' => $result_array['data'][$i]['zoneName'],
			'*{zoneId}*' => $result_array['data'][$i]['zoneId']
			);
	$footer_zone_list_part = replace_tags_html($tags_arr,$footer_zone_list_part);
	$footer_zone_list = $footer_zone_list.$footer_zone_list_part;
	//tab pane
	$zone_tab_pane_template = file_get_contents('templates/account/zone_tab_pane_template.html');
	
	$request1 = array();
	$request1['request'] = array('contestId'=>$contest_id,'zoneId'=>$result_array['data'][$i]['zoneId']);
	$request1_json = json_encode($request1);

	$api1 = API_URL.'getCompaniesByContestIdAndZoneId';

	$curl_obj1 = new curl($request1_json,$api1);

	$result1 = $curl_obj1->exec_curl(); 

	$result1_array = json_decode($result1,true);
	
	$company_point = '';
	for($j=0;$j<count($result1_array['data']);$j++){
		$company_point_template = file_get_contents('templates/account/company_point_template.html');
		$tags_arr=array(
			'*{companyName}*' => $result1_array['data'][$j]['CompanyCode'],
			'*{companyID}*' => $result1_array['data'][$j]['companyId'],
			'*{companyPoint}*' => $result1_array['data'][$j]['companyPoint'],
			'*{companyZoneId}*' => $result1_array['data'][$j]['zoneId'],
			'*{companyZoneName}*' => $result1_array['data'][$j]['ZoneName']
			);
		$company_point_template = replace_tags_html($tags_arr,$company_point_template);
		
		$company_point = $company_point.$company_point_template;
	}
	
	$tags_arr=array(
			'*{zoneId}*' => $result_array['data'][$i]['zoneId'],
			'*{company_point}*' => $company_point,
			'*{zoneName}*' => $result_array['data'][$i]['zoneName']
			);
	$zone_tab_pane_template = replace_tags_html($tags_arr,$zone_tab_pane_template);
	$zone_tab_pane = $zone_tab_pane.$zone_tab_pane_template;
}

$game_team_link = BASE_URL.'game_team.php?contest_id='.$contest_id;

$content = str_replace('*{zone_tab_pane}*',$zone_tab_pane,$content);
$content = str_replace('*{footer_zone_list}*',$footer_zone_list,$content);
$content = str_replace('*{zoneids}*',$zoneids,$content);
$content = str_replace('*{game_team_link}*',$game_team_link,$content);
$content = str_replace('*{contest_id}*',$contest_id,$content);
$content = str_replace('*{team_id}*','<input type="hidden" name="team_id" value="'.$team_id.'">',$content);

if(isset($_SESSION['company'])){
	$output='';
	for($i=0;$i<count($_SESSION['company']);$i++){
		$out = file_get_contents('templates/account/comapny_js.html');
		$company_inf_arr = explode('|',$_SESSION['company'][$i]);
		$company_id = $company_inf_arr[0];
		$out = str_replace('*{companyId}*',$company_id,$out);
		$output = $output.$out;
	}
	$session_storage = $output;
	unset($_SESSION['company']);
}else{
	$output='';
	for($i=0;$i<count($result_array_company['data']);$i++){
		$out = file_get_contents('templates/account/comapny_js.html');
		$company_id = $result_array_company['data'][$i]['CompanyID'];
		$out = str_replace('*{companyId}*',$company_id,$out);
		$output = $output.$out;
	}
	$session_storage = $output;
}

$content = str_replace('*{session_storage}*',$session_storage,$content);

if(isset($_SESSION['team_exist'])){
	$team_exist = '<div style="color: green;">Team already exist.</div>';
	unset($_SESSION['team_exist']);
}else{
	$team_exist = '';
}

$content = str_replace('*{team_exist}*',$team_exist,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

?>