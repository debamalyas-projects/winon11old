<?php
class Kite_model extends CI_Model
{
	protected $kiteConnect;
	protected $kiteAccessToken;
	public function __construct(){
		include APPPATH . 'third_party/KiteConnect/KiteConnect.php';
		$this->kiteConnect = new KiteConnect(ZERODHA_API_KEY);
		$this->kiteAccessToken = $this->getLatestAccessToken(); 
	}
	
	public function loginKite(){
		
		$login_url = $this->kiteConnect->getLoginURL();
		return $login_url;
	}
	
	public function generateKiteAccessToken($data){		
			try {
				$user = $this->kiteConnect->generateSession($data['request_token'] , ZERODHA_API_SECRET);
				//echo "<pre>"; print_r($user); die();
				if(isset($user->access_token) && $this->saveKiteAccessToken($user)){
						$response['message'] = "Authentication successful";
						$response['status'] = "success";
				} else {
						$response['message'] = "Unable to record the data";
						$response['status'] = "failed";
				}
			} catch(Exception $e) {
				 $response['message'] = "Authentication failed: ".$e->getMessage();
				 $response['status'] = "failed";
			}
			return $response;
	}
	
	public function saveKiteAccessToken($data){
		
		/* Disable old access tokens */
		$this->disableOldKitAccessToken();
		/* Disable old access token */
		
		$data = array('ApiResponse' => serialize($data), 'Status' => '1', 'CreatedOn' => date('Y-m-d H:i:s', strtotime($data->login_time->date)));
		$this->db->trans_start();
        $this->db->insert('kite_access_token', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
		return $insert_id;
	}
	
	public function disableOldKitAccessToken(){
		$this->db->where('Status', '1');
		$data = array('status' => '0');
        $this->db->update('kite_access_token', $data);
	}
	
	
	public function getLatestAccessToken(){
		
		$accessToken = '';
		
		$this->db->select('ApiResponse');
        $this->db->from('kite_access_token');
        $this->db->where('Status', '1');
		$this->db->order_by('CreatedOn', 'DESC');
		$this->db->limit(1, 0);
        $query = $this->db->get();
		//echo "<pre>"; print_r($this->db->last_query());  echo "</pre>";   
        if($query->num_rows() > 0){
			$result = $query->result();
			if(isset($result[0])){
				$ApiResponse = $result[0]->ApiResponse;
				$ApiResponse = unserialize($ApiResponse);
				$accessToken = $ApiResponse->access_token;
				//echo "<pre>"; print_r($ApiResponse);  echo "</pre>";  
			}
		}
		//echo $accessToken; die();
		return $accessToken;
	}
	
	public function getInstruments($exchange){
		$instruments = $this->kiteConnect->getInstruments($exchange);
		return $instruments;
	}
	
	
	public function saveInstruments($Instruments){
		
		$this->db->trans_start();
		$this->db->update('company', array('Status' => '0'));
		$this->db->trans_complete();
		
		$data_insert = array();
		$data_update = array();
		$recordInserted = 0;
		$recordUpdated = 0;
		$totalRecords  = count($Instruments);
		foreach($Instruments as $Instrument){
			if($this->checkInstrumentExists($Instrument->tradingsymbol)){
				$data_insert[] = array('CompanyName' => (isset($Instrument->name) && $Instrument->name != '') ? $Instrument->name : $Instrument->tradingsymbol, 'CompanyCode' => $Instrument->tradingsymbol, 'InstrumentToken' => $Instrument->instrument_token, 'ExchangeToken' => $Instrument->exchange_token, 'InstrumentType' => $Instrument->instrument_type, 'Segment' => $Instrument->segment, 'Exchange' => $Instrument->exchange, 'Status' => '1',  'CreatedOn' => date('Y-m-d H:i:s'), 'UpdatedOn' => NULL);
			} else {
				$data_update[] = array('CompanyName' => (isset($Instrument->name) && $Instrument->name != '') ? $Instrument->name : $Instrument->tradingsymbol, 'CompanyCode' => $Instrument->tradingsymbol, 'InstrumentToken' => $Instrument->instrument_token, 'ExchangeToken' => $Instrument->exchange_token, 'InstrumentType' => $Instrument->instrument_type, 'Segment' => $Instrument->segment, 'Exchange' => $Instrument->exchange, 'Status' => '1',  'UpdatedOn' => date('Y-m-d H:i:s'));	
			}
		}
		
		// echo "Insert Data ================= <pre>"; print_r($data_insert); echo "</pre>";
		// echo "Update Data ================= <pre>"; print_r($data_update); echo "</pre>";
		//die();
		
		if(count($data_insert) > 0 ){ 
			$this->db->trans_start();
			$recordInserted = $this->db->insert_batch('company', $data_insert, NULL, 200);
			$this->db->trans_complete();
		}
		
		if(count($data_update) > 0){
			foreach($data_update as $instrument){
				$this->db->trans_start();
				$this->db->where('CompanyCode', $instrument['CompanyCode']);
				//$this->db->where('Status', '1');
				$this->db->update('company', $instrument);
				if($this->db->affected_rows() > 0){
					$recordUpdated++;
				}
				$this->db->trans_complete();
			}
			
		}
		
		$response = array('totalRecords' => $totalRecords, 'newRecordsInserted' => $recordInserted, 'existingRecordsUpdated' => $recordUpdated);
		
		return $response;
		
		
	}
	
	public function checkInstrumentExists($companyCode){
		$this->db->select('ID');
        $this->db->from('company');
        $this->db->where('CompanyCode', $companyCode);
        $query = $this->db->get(); 
        if($query->num_rows() > 0){
			$response = false;
		} else {
			$response = true;
		}
		return $response;
	}
	
	/*
	* @description get all the companies with status - active
	* @author PSKS Web Services <pskswebservices@gmail.com>
	* @param NULL
	* @return array 
	* @since July 29, 2019
	*/	
	public function getAllCompanies(){
		$this->db->select('*');
        $this->db->from('company');
        $this->db->where('Status', '1');
		$this->db->order_by('CompanyName','ASC');
        $query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	public function getAllCompanies_contest(){
		$this->db->select('*');
        $this->db->from('company_contest');
        $this->db->where('Status', '1');
		$this->db->order_by('CompanyName','ASC');
        $query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	public function getAllCompaniesLimit($start,$limit){
		$query = $this->db->query('SELECT * FROM `company` WHERE `Status`="1" ORDER BY `CompanyName` ASC LIMIT '.$start.','.$limit);
		
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	public function getAllCompaniesLimit_contest($start,$limit){
		$query = $this->db->query('SELECT * FROM `company_contest` ORDER BY `CompanyName` ASC LIMIT '.$start.','.$limit);
		
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	public function getTemp(){
		$query = $this->db->query('SELECT * FROM `zerodha_temp`');
		
		$result = $query->result_array();
		
		return $result;
	}
	
	public function getTemp_contest(){
		$query = $this->db->query('SELECT * FROM `zerodha_temp_contest`');
		
		$result = $query->result_array();
		
		return $result;
	}
	
	public function updateTemp($start,$length,$status){
		$this->db->query('UPDATE `zerodha_temp` SET `start`="'.$start.'", `length`="'.$length.'", `status`="'.$status.'"');
	}
	
	public function updateTemp_contest($start,$length,$status){
		$this->db->query('UPDATE `zerodha_temp_contest` SET `start`="'.$start.'", `length`="'.$length.'", `status`="'.$status.'"');
	}
	
	public function updateTempStatus($status){
		$this->db->query('UPDATE `zerodha_temp` SET `status`="'.$status.'"');
	}
	
	public function updateTempStatus_contest($status){
		$this->db->query('UPDATE `zerodha_temp_contest` SET `status`="'.$status.'"');
	}
	
	public function updateInstrumentsHistoricalData($instruments, $interval, $from_date_time, $to_date_time, $continuous){
		
		ini_set('max_execution_time', -1); 
		ini_set('memory_limit','10000M');
		set_time_limit(0);
		
		$this->kiteConnect->setAccessToken($this->kiteAccessToken);
		foreach($instruments as $instrument){
			if(isset($instrument->InstrumentToken)) {
				try {
					$historicalData = $this->kiteConnect->getHistoricalData($instrument->InstrumentToken, $interval, $from_date_time, $to_date_time, $continuous);
					$result = $this->saveInstrumentsHistoricalData($instrument->ID, $historicalData);
					$response[$instrument->InstrumentToken]['numberOfHistoricalRecordsInserted'] = $result['companyID'];
					$response[$instrument->InstrumentToken]['CompanyName'] = $instrument->CompanyName;
					$response[$instrument->InstrumentToken]['CompanyCode'] = $instrument->CompanyCode;
					$response[$instrument->InstrumentToken]['FromDate'] = $from_date_time;
					$response[$instrument->InstrumentToken]['ToDate'] = $to_date_time;
					$response[$instrument->InstrumentToken]['numberOfHistoricalRecordsInserted'] = $result['noOfRecords'];
					$response[$instrument->InstrumentToken]['status'] = 'success';
				} catch(Exception $e) {
					$response[$instrument->InstrumentToken]['message'] = "Authentication failed: ".$e->getMessage();
					$response[$instrument->InstrumentToken]['status'] = "failed";
				}
			}
		}
		return $response;
	}
	
	public function updateContestInstrumentsHistoricalData($instruments, $interval, $from_date_time, $to_date_time, $continuous){
		
		ini_set('max_execution_time', -1); 
		ini_set('memory_limit','10000M');
		set_time_limit(0);
		
		$this->kiteConnect->setAccessToken($this->kiteAccessToken);
		foreach($instruments as $instrument){
			if(isset($instrument->InstrumentToken)) {
				try {
					$historicalData = $this->kiteConnect->getHistoricalData($instrument->InstrumentToken, $interval, $from_date_time, $to_date_time, $continuous);
					
					$result = $this->saveContestInstrumentsHistoricalData($instrument->ID, $historicalData);
					$response[$instrument->InstrumentToken]['numberOfHistoricalRecordsInserted'] = $result['companyID'];
					$response[$instrument->InstrumentToken]['CompanyName'] = $instrument->CompanyName;
					$response[$instrument->InstrumentToken]['CompanyCode'] = $instrument->CompanyCode;
					$response[$instrument->InstrumentToken]['FromDate'] = $from_date_time;
					$response[$instrument->InstrumentToken]['ToDate'] = $to_date_time;
					$response[$instrument->InstrumentToken]['numberOfHistoricalRecordsInserted'] = $result['noOfRecords'];
					$response[$instrument->InstrumentToken]['status'] = 'success';
				} catch(Exception $e) {
					$response[$instrument->InstrumentToken]['message'] = "Authentication failed: ".$e->getMessage();
					$response[$instrument->InstrumentToken]['status'] = "failed";
				}
			}
		}
		return $response;
	}
	
	public function saveInstrumentsHistoricalData($companyID, $historicalData){
		
		$recordInserted = 0;
		$data_insert = array();
		if(count($historicalData) > 0){
			foreach($historicalData as $data){
				$dateTime = $data->date;
				if($this->checkDuplicateHistoricalData($companyID, $dateTime->format('Y-m-d H:i:s'))){
					$data_insert[] = array('CompanyID' => $companyID, 'Date' => $dateTime->format('Y-m-d H:i:s'), 'OpenPrice' => $data->open, 'HighPrice' => $data->high, 'LowPrice' => $data->low, 'ClosePrice' => $data->close, 'Volume' => $data-> volume, 'Status' => '1', 'CreatedOn' => date('Y-m-d H:i:s', time()));
				}
			}
			//echo "Insert Data ================= <pre>"; print_r($data_insert); echo "</pre>"; die();
			if(count($data_insert) > 0 ){ 
				$this->db->trans_start();
				$recordInserted = $this->db->insert_batch('companyhistoricaldata', $data_insert, NULL, 200);
				$this->db->trans_complete();
			}
		}
		
		$response = array('noOfRecords' => $recordInserted, 'companyID' => $companyID);
		return $response;
	}
	
	public function saveContestInstrumentsHistoricalData($companyID, $historicalData){
		
		$recordInserted = 0;
		$data_insert = array();
		if(count($historicalData) > 0){
			foreach($historicalData as $data){
				$dateTime = $data->date;
				if($this->checkDuplicateContestHistoricalData($companyID, $dateTime->format('Y-m-d H:i:s'))){
					$data_insert[] = array('CompanyID' => $companyID, 'Date' => $dateTime->format('Y-m-d H:i:s'), 'OpenPrice' => $data->open, 'HighPrice' => $data->high, 'LowPrice' => $data->low, 'ClosePrice' => $data->close, 'Volume' => $data-> volume, 'Status' => '1', 'CreatedOn' => date('Y-m-d H:i:s', time()));
				}
			}
			//echo "Insert Data ================= <pre>"; print_r($data_insert); echo "</pre>"; die();
			if(count($data_insert) > 0 ){ 
				$this->db->trans_start();
				$recordInserted = $this->db->insert_batch('companyhistoricaldata_contest', $data_insert, NULL, 200);
				$this->db->trans_complete();
			}
		}
		
		$response = array('noOfRecords' => $recordInserted, 'companyID' => $companyID);
		return $response;
	}
	
	public function checkDuplicateHistoricalData($companyID,$dateTime){
		$this->db->select('ID');
        $this->db->from('companyhistoricaldata');
        $this->db->where('CompanyID', $companyID);
		$this->db->where('Date', $dateTime);
		$this->db->where('Status', '1');
        $query = $this->db->get(); 
        if($query->num_rows() > 0){
			$response = false;
		} else {
			$response = true;
		}
		return $response;
	}
	
	public function checkDuplicateContestHistoricalData($companyID,$dateTime){
		$this->db->select('ID');
        $this->db->from('companyhistoricaldata_contest');
        $this->db->where('CompanyID', $companyID);
		$this->db->where('Date', $dateTime);
		$this->db->where('Status', '1');
        $query = $this->db->get(); 
        if($query->num_rows() > 0){
			$response = false;
		} else {
			$response = true;
		}
		return $response;
	}
	
	public function testInstrument($InstrumentToken, $interval, $from_date_time, $to_date_time, $continuous){
		$this->kiteConnect->setAccessToken($this->kiteAccessToken);
		$historicalData = $this->kiteConnect->getHistoricalData($InstrumentToken, $interval, $from_date_time, $to_date_time, $continuous);
		print_r($historicalData);
	}
}
?>