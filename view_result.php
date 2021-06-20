<?php
include('common/include.php');

check_login();

if(isset($_SESSION['company'])){
	unset($_SESSION['company']);
}

$Id=$_SESSION['customer']['id'];
$contest_id = $_GET['contest_id'];
	
$header = file_get_contents('templates/account/common/header.html');
$dashboard = file_get_contents('templates/account/contest.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$dashboard.$footer;
$contest_list='';
$leader_board='';
$leader_board_others='';
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
$request['query'] = "SELECT * FROM `contests` WHERE `ID`='".$contest_id."'";

$request_json = json_encode($request);


$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array1 = json_decode($result,true);

$request = array();
$request['query'] = "SELECT * FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";

$request_json = json_encode($request);


$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array2 = json_decode($result,true);


for($i=0;$i<count($result_array2['data']);$i++){
	if($i%2==0){
		$contest = file_get_contents('templates/account/contest_list.html');
	}else{
		$contest = file_get_contents('templates/account/contest_list.html');
	}
	if($result_array2['data'][$i]['lowerBoundRank']!=$result_array2['data'][$i]['upperBoundRank']){
		$rank = $result_array2['data'][$i]['lowerBoundRank'].' '.'-'.' '.$result_array2['data'][$i]['upperBoundRank'];
	}else{
		$rank = $result_array2['data'][$i]['lowerBoundRank'];
	}
	$tags_arr=array(
			'*{rank}*' => $rank,
			'*{money}*' =>'₹'.$result_array2['data'][$i]['prizeMoney'],
			);
	$contest = replace_tags_html($tags_arr,$contest);
	$contest_list = $contest_list.$contest;
}

$tags_arr=array(
			'*{contest_name}*' => $result_array1['data'][0]['ContestName'],
			'*{contest_prize}*' =>'₹'.$result_array1['data'][0]['ContestFinalPrizePool'],
			'*{total_players}*' =>$result_array1['data'][0]['ContestSpotsJoined'],
			'*{contest_entry_fee}*'=>'₹'.$result_array1['data'][0]['ContestEntryFees']
			);

$content = replace_tags_html($tags_arr,$content);
$content = str_replace("*{contest_list}*",$contest_list,$content);

$status=1;
//leader board
$request = array();
$request['query'] = "SELECT * FROM `rank`,`customers` WHERE `rank`.`CustomerID`=`customers`.`ID` AND `rank`.`ContestID`='".$contest_id."' AND `rank`.`CustomerID`='".$Id."' AND `rank`.`Status`='".$status."' ORDER BY `rank`.`Rank` ASC";

$request_json = json_encode($request);


$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);


for($i=0,$k=1;$i<count($result_array['data']);$i++,$k++){
	if($i%2==0){
		$contest = $contest = file_get_contents('templates/account/leader_board_running_contest.html');
	}else{
		$contest = file_get_contents('templates/account/leader_board__class_running_contest.html');
	}
	$tags_arr=array(
			'*{team_name}*' => $result_array['data'][$i]['FirstName'].'-'.'team'.$result_array['data'][$i]['TeamID'],
			'*{rank}*' => $result_array['data'][$i]['Rank'],
			'*{money}*' =>$result_array['data'][$i]['Score'],
			'*{customer_id}*' =>$result_array['data'][$i]['CustomerID'],
			'*{contest_id}*' =>$contest_id,
			'*{team_id}*' =>$result_array['data'][$i]['TeamID']
			);
	$contest = replace_tags_html($tags_arr,$contest);
	$leader_board = $leader_board.$contest;

}
$content = str_replace("*{leader_board}*",$leader_board,$content);


$request = array();
$request['query'] = "SELECT * FROM `rank`,`customers` WHERE `rank`.`CustomerID`=`customers`.`ID` AND `rank`.`ContestID`='".$contest_id."' AND `rank`.`Status`='".$status."'ORDER BY `rank`.`Rank` ASC";

$request_json = json_encode($request);


$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array1 = json_decode($result,true);

for($i=0,$k=1;$i<count($result_array1['data']);$i++,$k++){
	if($i%2==0){
		$contest = $contest = file_get_contents('templates/account/leader_board_running_contest.html');
	}else{
		$contest = file_get_contents('templates/account/leader_board_running_contest.html');
	}
	$tags_arr=array(
			'*{team_name}*' => $result_array1['data'][$i]['FirstName'].'-'.'team'.$result_array1['data'][$i]['TeamID'],
			'*{rank}*' => $result_array1['data'][$i]['Rank'],
			'*{money}*' =>$result_array1['data'][$i]['Score'],
			'*{customer_id}*' =>$result_array1['data'][$i]['CustomerID'],
			'*{contest_id}*' =>$contest_id,
			'*{team_id}*' =>$result_array1['data'][$i]['TeamID']
			);
	$contest = replace_tags_html($tags_arr,$contest);
	$leader_board_others = $leader_board_others.$contest;
}
$content = str_replace("*{leader_board_others}*",$leader_board_others,$content);
//leader board
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;
?>