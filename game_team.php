<?php
include('common/include.php');

check_login();

if(!isset($_GET['contest_id'])){
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
$contestSpotsAvailable = $result_array['data'][0]['ContestSpotsAvailable'];

if($closingStatus!=1){
	header('location:game.php');
}

$Id=$_SESSION['customer']['id'];
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/game_team.html');
$footer = file_get_contents('templates/account/common/footer.html');

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
			'*{joined_game_link}*' => 'joined_game.php',
			'*{contest_id}*' => $contest_id,
			'*{running_contest_link}*' => 'running_contest.php',
			'*{active_status_game}*'=>'active',
			'*{contest_over_link}*' => 'contest_over.php',
			);
$content = replace_tags_html($tags_arr,$content);

$request = array();
$request['query'] = "SELECT MAX(`TeamID`) AS `no_team` FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$Id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$no_of_teams = $result_array['data'][0]['no_team'];

$team_block='';
for($i=1;$i<=$no_of_teams;$i++){
	$out=file_get_contents('templates/account/part_team_block.html');
	//Platinum Company
	$request = array();
	$request['query'] = "SELECT * FROM `customerteam` 
LEFT JOIN `company` ON `customerteam`.`CompanyID`=`company`.`ID`
WHERE `customerteam`.`ContestID`='".$contest_id."' AND `customerteam`.`CustomerID`='".$Id."' AND `customerteam`.`TeamID`='".$i."' AND `customerteam`.`IsPrimaryCompany`='1'";

	$request_json = json_encode($request);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$platinum = $result_array['data'][0]['CompanyCode'];
	
	//Diamond Company
	$request = array();
	$request['query'] = "SELECT * FROM `customerteam` 
LEFT JOIN `company` ON `customerteam`.`CompanyID`=`company`.`ID`
WHERE `customerteam`.`ContestID`='".$contest_id."' AND `customerteam`.`CustomerID`='".$Id."' AND `customerteam`.`TeamID`='".$i."' AND `customerteam`.`IsSecondaryCompany`='1'";

	$request_json = json_encode($request);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array = json_decode($result,true);
	
	$diamond = $result_array['data'][0]['CompanyCode'];
	
	
	$tags_arr=array(
			'*{platinum}*' => $platinum,
			'*{diamond}*' => $diamond,
			'*{contest_id}*'=> $contest_id,
			'*{customer_id}*' => $Id,
			'*{team_id}*' => $i
			);
	$out = replace_tags_html($tags_arr,$out);
	
	$team_block=$team_block.$out;
}

$content = str_replace('*{team_block}*',$team_block,$content);

$request = array();
$request['query'] = "SELECT * FROM `contests` WHERE `ID`='".$contest_id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$max_team_allowed = $result_array['data'][0]['ContestMaximumTeamAllowed'];

if($max_team_allowed<=$no_of_teams){
	$create_team_button = '<div>Maximum allowed teams for this contest is '.$max_team_allowed.'</div>';
}else{
	$request = array();
	$request['tableName'] = 'customers';
	$request['fields'] = array('ID'=>$Id);

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
	
	if($amount_in_wallet<$contest_entry_fee){
		$create_team_button = '<div>You don\'t have sufficient amount in wallet to create further teams.</div>';
	}else{
		if($contestSpotsAvailable==0){
			$create_team_button = '<div>Spots for this contest are filled up.</div>';
		}else{
			$create_team_button = '<a class="genric-btn btn-warning" href="game_create_team.php?contest_id='.$contest_id.'">Create Team</a>';
		}
	}
}

$content = str_replace('*{create_team_button}*',$create_team_button,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

?>