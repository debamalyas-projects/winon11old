<?php
class aadharImpliment{
	public $aadharNumber;
	
	public function aadharVerification($aadharNumber){
		$curl = curl_init();
		$this->aadharNumber= $aadharNumber;

		curl_setopt_array($curl, array(
			CURLOPT_URL => AADHAR_NUMBER_LINK."uidnumber=$this->aadharNumber&clientid=".CLIENTID."&method=".METHOD."&txn_id=".TXN_ID,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => CURLOPT_MAXREDIRS_NO,
			CURLOPT_TIMEOUT => CURLOPT_TIMEOUT_NO,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"content-type: content-type",
				"x-rapidapi-host: aadhaarnumber-verify.p.rapidapi.com",
				"x-rapidapi-key: 43763226fbmsh713fd22fd0520f5p19e977jsn720f6f3f2906"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$response_arr = json_decode($response,true);
		
		
		if(array_key_exists("Succeeded",$response_arr)){
			return '1';
		}else if(array_key_exists("Failed",$response_arr)){
			return '0';
		}else{
			return '2';
		}
	}
}

?>

	