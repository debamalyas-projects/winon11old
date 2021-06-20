<?php
include('common/include.php');

check_login();

$Id=$_SESSION['customer']['id'];
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/game_entry_fee.html');
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
			'*{game_link_entry_fee}*' => 'game_entry_fee.php',
			'*{game_link_contest_size}*' => 'game_contest_size.php',
			'*{running_contest_link}*' => 'running_contest.php',
			'*{active_status_game}*'=>'active',
			'*{contest_over_link}*' => 'contest_over.php'
			);
$content = replace_tags_html($tags_arr,$content);

$request = array();
$request['request'] = array('userId'=>$Id,'orderBy'=>"ContestEntryFees");

$request_json = json_encode($request);


$api = API_URL.'contestListing';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

$game_out = '';
for($i=0;$i<count($result_array['data']);$i++){
	$game=file_get_contents('templates/account/game_lists.html');
	if($result_array['data'][$i]['ContestSpotsJoined']==Null){
		$ContestSpotsJoined = 0;
	}else{
		$ContestSpotsJoined = $result_array['data'][$i]['ContestSpotsJoined'];
	}
	$tags_arr=array(
			'*{contestName}*' => $result_array['data'][$i]['ContestName'],
			'*{ContestOpenDateTime}*' => $result_array['data'][$i]['ContestOpenDateTime'],
			'*{prize}*' =>'₹'.$result_array['data'][$i]['ContestPrizePool'],
			'*{entryFee}*'=>'₹'.$result_array['data'][$i]['ContestEntryFees'],
			'*{max}*' => $result_array['data'][$i]['ContestMaximumTeamAllowed'],
			'*{totalSlots}*' => $result_array['data'][$i]['ContestSpotsTotal'],
			'*{contest_id}*' => $result_array['data'][$i]['ID'],
			'*{joined}*' => $ContestSpotsJoined,
			'*{slotsAvailable}*' => $result_array['data'][$i]['ContestSpotsTotal']-$ContestSpotsJoined
			);
	$game = replace_tags_html($tags_arr,$game);

	$game_out = $game_out.$game;
}

if($game_out==''){
	$game_out='<tr><td style="text-align: center;">There are no upcoming contests.</td></tr>';
}

$content = str_replace("*{game_lists}*",$game_out,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;

?>