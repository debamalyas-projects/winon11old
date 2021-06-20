<?php
class Kite extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('kite_model');
	}

	public function index(){
		$this->loginKite();
	}

	public function loginKite(){
		$loginUrl = $this->kite_model->loginKite();
		redirect($loginUrl);
	}

	public function registerSaveSession(){
		$requestData = $this->input->get();
		if(isset($requestData['status']) && $requestData['status'] == 'success' && isset($requestData['action']) && $requestData['action'] == 'login' && isset($requestData['request_token']) && $requestData['request_token'] != '' ){
			$response = $this->kite_model->generateKiteAccessToken($requestData);
			if($response['status'] == 'failed'){
				$this->loginKite();
			} else {
				echo "New Session Initialized for next 24 Hours.";
			}
		} else {
			$this->loginKite();
		}
	}

	public function getLatestInstruments(){
		$exchange = 'NSE';
		$instruments = $this->kite_model->getInstruments($exchange);
		//echo "<pre>"; print_r($instruments); echo "</pre>";
		$response = array('totalRecords' => count($instruments), 'newRecordsInserted' => 0, 'existingRecordsUpdated' => 0);
		if(count($instruments)){
			$response = $this->kite_model->saveInstruments($instruments);		
		}
		
		$this->kite_model->updateTemp(0,0,'finish');
		
		echo "<pre>"; print_r($response); echo "</pre>";
	}

	public function updateAllInstrumentsHistoricalData(){
		
		$zerodha_temp = $this->kite_model->getTemp();
		
		$start = $zerodha_temp[0]['start'];
		$length = $zerodha_temp[0]['length'];
		$status = $zerodha_temp[0]['status'];
		
		$companies = $this->kite_model->getAllCompanies();
		
		$count = count($companies);
		
		if($status=='finish'){
			if($length==0){
				$this->kite_model->updateTempStatus('running');
				$currentTime = time();
				
				$companies = $this->kite_model->getAllCompaniesLimit($start,25);
				$response = array();
				if(count($companies) > 0 ){
					$from_time = date('Y-m-d H:i:s', ($currentTime - 36000));
					$to_time  = date('Y-m-d H:i:s', $currentTime);
					$from_date_time = new DateTime($from_time);
					$to_date_time = new DateTime($to_time);
					$response = $this->kite_model->updateInstrumentsHistoricalData($companies, '5minute', $from_date_time, $to_date_time, false);
				}
				
				$new_start = $start+25;
				$new_length = $count-25;
				
				$this->kite_model->updateTemp($new_start,$new_length,'finish');
				
				echo "<pre>"; print_r($response); echo "</pre>";
			}else{
				$this->kite_model->updateTempStatus('running');
				$currentTime = time();
				
				$companies = $this->kite_model->getAllCompaniesLimit($start,25);
				$response = array();
				if(count($companies) > 0 ){
					$from_time = date('Y-m-d H:i:s', ($currentTime - 36000));
					$to_time  = date('Y-m-d H:i:s', $currentTime);
					$from_date_time = new DateTime($from_time);
					$to_date_time = new DateTime($to_time);
					$response = $this->kite_model->updateInstrumentsHistoricalData($companies, '5minute', $from_date_time, $to_date_time, false);
				}
				
				$new_start = $start+25;
				$new_length = $length-25;
				
				if($new_length<=0){
					$new_length=0;
					$new_start = 0;
				}
				
				$this->kite_model->updateTemp($new_start,$new_length,'finish');
				
				echo "<pre>"; print_r($response); echo "</pre>";
			}
		}else{
			echo'Exit'; die();
		}
	}
	
	public function updateContestInstrumentsHistoricalData(){
		
		$zerodha_temp_contest = $this->kite_model->getTemp_contest();
		
		$start = $zerodha_temp_contest[0]['start'];
		$length = $zerodha_temp_contest[0]['length'];
		$status = $zerodha_temp_contest[0]['status'];
		
		$companies = $this->kite_model->getAllCompanies_contest();
		
		$count = count($companies);
		
		if($status=='finish'){
			if($length==0){
				$this->kite_model->updateTempStatus_contest('running');
				$currentTime = time();
				
				$companies = $this->kite_model->getAllCompaniesLimit_contest($start,25);
				$response = array();
				if(count($companies) > 0 ){
					$from_time = date('Y-m-d H:i:s', ($currentTime - 36000));
					$to_time  = date('Y-m-d H:i:s', $currentTime);
					$from_date_time = new DateTime($from_time);
					$to_date_time = new DateTime($to_time);
					$response = $this->kite_model->updateContestInstrumentsHistoricalData($companies, '5minute', $from_date_time, $to_date_time, false);
				}
				
				$new_start = $start+25;
				$new_length = $count-25;
				
				if($new_length<=0){
					$new_length=0;
					$new_start=0;
				}
				
				$this->kite_model->updateTemp_contest($new_start,$new_length,'finish');
				
				echo "<pre>"; print_r($response); echo "</pre>";
			}else{
				$this->kite_model->updateTempStatus_contest('running');
				$currentTime = time();
				
				$companies = $this->kite_model->getAllCompaniesLimit_contest($start,25);
				$response = array();
				if(count($companies) > 0 ){
					$from_time = date('Y-m-d H:i:s', ($currentTime - 36000));
					$to_time  = date('Y-m-d H:i:s', $currentTime);
					$from_date_time = new DateTime($from_time);
					$to_date_time = new DateTime($to_time);
					$response = $this->kite_model->updateContestInstrumentsHistoricalData($companies, '5minute', $from_date_time, $to_date_time, false);
				}
				
				$new_start = $start+25;
				$new_length = $length-25;
				
				if($new_length<=0){
					$new_length=0;
					$new_start = 0;
				}
				
				$this->kite_model->updateTemp_contest($new_start,$new_length,'finish');
				
				echo "<pre>"; print_r($response); echo "</pre>";
			}
		}else{
			echo'Exit'; die();
		}
	}
	
	public function testInstrument(){
		$currentTime = time();
		$from_time = date('Y-m-d H:i:s', ($currentTime - 36000));
		$to_time  = date('Y-m-d H:i:s', $currentTime);
		$from_date_time = new DateTime($from_time);
		$to_date_time = new DateTime($to_time);
		
		$this->kite_model->testInstrument('969473', '5minute', $from_date_time, $to_date_time, false);
	}
}
?>