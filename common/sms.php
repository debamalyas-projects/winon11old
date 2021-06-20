<?php
class sms{
	public $smsParams;
	
	public function __construct($smsParams){
		$this->smsParams = $smsParams;
	}
	
	public function sendSMS(){
		$apiKey = urlencode(SMS_API_KEY);

		// Config variables. Consult http://api.textlocal.in/docs for more info.
		$test = "0";

		// Data for text message. This is the text message data.
		$sender = urlencode($this->smsParams['sender']); // This is who the message appears to be from.
		$numbers = implode(',',$this->smsParams['numbers']); // A single number or a comma-seperated list of numbers
		
		// 612 chars or less
		// A single number or a comma-seperated list of numbers
		$message = rawurlencode($this->smsParams['message']);
		$data = "apikey=".$apiKey."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
		$ch = curl_init(SMS_API_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		return json_decode($result);
	}
}