<?php

function pr($data){
	echo "<pre>"; print_r($data); echo "</pre>";
}

function zerodha_get_historical_data($interval = 'minute', $from_date_time, $to_date_time, $continuous = true){
	
	
	$kite = new KiteConnect(ZERODHA_API_KEY);
    // Assuming you have obtained the `request_token`
	// after the auth flow redirect by redirecting the
	// user to $kite->login_url()
	//$login_url = $kite->getLoginURL();

	/*$request_token = 'ggZuIFJUHJ5hi2GV06p42wlnmpZg6lhK';
	try {
		$user = $kite->generateSession($request_token , ZERODHA_API_SECRET);

		echo "Authentication successful. \n";
		pr($user);

		$kite->setAccessToken($user->access_token);
	} catch(Exception $e) {
		echo "Authentication failed: ".$e->getMessage();
		throw $e;
	}

	echo $user->user_id." has logged in"; 
	
	$access_token = $kite->access_token;die();*/
	$access_token = 'z81yk99xgS5n727m9nLZYu99nUlJwsAK';
	$kite->setAccessToken($access_token);
	$public_token =  $user->public_token;
	$public_token =  'CU7vjbVnEqvkB172AEQhuB2tg2enwjbZ';
	$_SESSION['access_token'] = $access_token;
	$_SESSION['public_token'] = $public_token;
	//$instruments = $kite->getInstruments('NSE');
	$historicalData = $kite->getHistoricalData('175361', $interval, $from_date_time, $to_date_time, $continuous);
	pr($historicalData); die();
}

/**
* params string $url, array $headers
* return array $output
*/
function curl_execute($url,$headers = array()){
	//  Initiate curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	$error_msg = 'No error';
	if (curl_error($ch)) {
		$error_msg = curl_error($ch);
	}
	//pr($_REQUEST);
	//pr($result);
	//pr($error_msg); die();
	// Closing
	curl_close($ch);

	$output = json_decode($result, true);
	return $output;
}

?>