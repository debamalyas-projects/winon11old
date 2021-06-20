<?php
include('common/include.php');

check_login();

if(isset($_SESSION['company'])){
	unset($_SESSION['company']);
}

$Id=$_SESSION['customer']['id'];
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/running_contest.html');
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
			'*{running_contest_link}*' => 'running_contest.php',
			'*{contest_over_link}*' => 'contest_over.php',
			'*{game_link_entry_fee}*' => 'game_entry_fee.php',
			'*{active_status_game}*'=>'active',
			'*{game_link_contest_size}*' => 'game_contest_size.php'
			);
$content = replace_tags_html($tags_arr,$content);
$request = array();
$request['query'] = "SELECT * FROM `contests` WHERE `ClosingStatus`= '2' ORDER BY `ID` DESC";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$game_out = '';

for($i=0;$i<count($result_array['data']);$i++){
	$request = array();
	$request['query'] = "SELECT count(*) AS `con` FROM `customerteam` WHERE `CustomerID`= '".$Id."' AND `ContestID`='".$result_array['data'][$i]['ID']."'";
	
	$request_json = json_encode($request);

	$api = API_URL.'select_query';

	$curl_obj = new curl($request_json,$api);

	$result = $curl_obj->exec_curl(); 

	$result_array2 = json_decode($result,true);
	
	$con = $result_array2['data'][0]['con'];
	
	if($con>0)
	{
		$game=file_get_contents('templates/account/running_contest_list.html');
		
		$tags_arr=array(
				'*{contestName}*' => $result_array['data'][$i]['ContestName'],
				'*{contest_final_prize_pool}*' =>'₹'.$result_array['data'][$i]['ContestFinalPrizePool'],
				'*{view_result_id}*'=>$result_array['data'][$i]['ID'],
				'*{no_of_teams}*' => $result_array['data'][$i]['ContestSpotsJoined'],
				);
		$game = replace_tags_html($tags_arr,$game);

		$game_out = $game_out.$game;
	}
}
if($game_out==''){
	$game_out='<div style="text-align: center;">There are no running contests.</div>';
}

$content = str_replace("*{game_lists}*",$game_out,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;