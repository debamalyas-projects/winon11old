<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Api extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('user_model');
		$this->load->model('contest_model');
	}
	
	public function get_entity_by_fields_from_table(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$tableName = $post_data['tableName'];
		$fields = $post_data['fields'];
		
		$result = $this->contest_model->get_entity_by_fields_from_table($tableName, $fields);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function select_query(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$query = $post_data['query'];
		
		$result = $this->contest_model->select_query($query);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function delete_query(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$query = $post_data['query'];
		
		$this->contest_model->delete_query($query);
		
		$response_arr = array();
		$response_arr['data'] = array();
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function dml_query(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$query = $post_data['query'];
		
		$this->contest_model->delete_query($query);
		
		$response_arr = array();
		$response_arr['data'] = array();
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function insert_entity_into_table(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$tableName = $post_data['tableName'];
		$fields = $post_data['fields'];
		
		$result = $this->contest_model->insert_entity_into_table($tableName, $fields);
		
		$response_arr = array();
		$response_arr['data'] = '';
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		$response_arr['message'] = '1';
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function update_entity_fields_by_fields_from_table(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$tableName = $post_data['tableName'];
		$fields_to_be_updated = $post_data['fields_to_be_updated'];
		$fields = $post_data['fields'];
		
		$result = $this->contest_model->update_entity_fields_by_fields_from_table($tableName, $fields_to_be_updated, $fields);
		
		$response_arr = array();
		$response_arr['data'] = '';
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		$response_arr['message'] = '1';
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}

	public function new_register(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$FirstName = $post_data->request->firstName;
		$LastName = $post_data->request->lastName;
		$MobileNumber = $post_data->request->mobile;
		$EmailAddress = $post_data->request->email;
		$Password = $post_data->request->password;
		
		$result1 = $this->customer_model->checkCustomerExists($EmailAddress, '');
		$result2 = $this->customer_model->checkCustomerExists('', $MobileNumber);
		
		if(!empty($result1) || !empty($result2)){
			$response_arr = array();
			$response_arr['data'] = $post_data;
			$response_arr['status'] = 200;
			$response_arr['isSuccess'] = false;
			$response_arr['message'] = 'User is already registered.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}else{
			$customerInfo = array('FirstName'=>$FirstName,
								 'LastName'=>$LastName,
								 'UserName'=>$EmailAddress,
								 'Password'=>$Password,
								 'MobileNumber'=>$MobileNumber,
								 'EmailAddress'=>$EmailAddress,
								 'PanNumber'=>'',
								 'AadharNumber'=>'',
								 'MobileVerificationStatus'=>'0',
								 'MobileVerificationCode'=>time().'mobile',
								 'EmailVerificationStatus'=>'0',
								 'EmailVerificationCode'=>time().'email',
								 'FacebookLinkedAccount'=>'0',
								 'FacebookAccountEmailAddress'=>'',
								 'GoogleLinkedAccount'=>'0',
								 'GoogleAccountEmailAddress'=>'',
								 'createdBy'=>1,
								 'updatedBy'=>1, 
								 'createdOn'=>date('Y-m-d H:i:s'), 
								 'updatedOn'=>date('Y-m-d H:i:s')
								 );
			$this->load->model('customer_model');
            $result = $this->customer_model->addNewCustomerApi($customerInfo);
			
			$response_arr = array();
			$response_arr['data'] = $customerInfo;
			$response_arr['status'] = 200;
			$response_arr['isSuccess'] = true;
			$response_arr['message'] = 'User is successfully registered.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}
	}
	
	public function login(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$EmailAddress = $post_data->request->userId;
		$Password = $post_data->request->password;
		
		$this->load->model('customer_model');
        $result = $this->customer_model->loginApi($EmailAddress,$Password);
		
		if(empty($result)){
			$response_arr = array();
			$response_arr['data'] = '';
			$response_arr['status'] = 401;
			$response_arr['isSuccess'] = false;
			$response_arr['message'] = 'Invalid username or password.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}else{
			$status = $result[0]->Status;
			if($status==0){
				$response_arr = array();
				$response_arr['data'] = '';
				$response_arr['status'] = 401;
				$response_arr['isSuccess'] = false;
				$response_arr['message'] = 'Your userid is inactive. Please contact administrator for further details.';
				
				$response_json = json_encode($response_arr);
				echo $response_json;
			}else{
				$access_token = time().'_'.$result[0]->ID;
				$this->customer_model->updateAccessToken($access_token,$result[0]->ID);
				
				$response_arr = array();
				$response_arr['data'] = array('userId'=>$result[0]->ID,'active_access_token'=>$access_token,'loginId'=>$result[0]->EmailAddress,'email'=>$result[0]->EmailAddress,'firstName'=>$result[0]->FirstName,'lastName'=>$result[0]->LastName);
				$response_arr['status'] = 200;
				$response_arr['isSuccess'] = true;
				$response_arr['message'] = 'Login successful.';
				
				$response_json = json_encode($response_arr);
				echo $response_json;
			}
		}
	}
	
	public function logout(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		$this->customer_model->updateAccessToken('',$customerId);
		
		$response_arr = array();
		$response_arr['data'] = '';
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		$response_arr['message'] = 'Logout successful.';
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function checkLoggedIn(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		$AccessToken = $post_data->request->active_access_token;
		
		$result = $this->customer_model->checkLoggedIn($customerId,$AccessToken);
		
		if(empty($result)){
			$response_arr = array();
			$response_arr['data'] = '';
			$response_arr['status'] = 401;
			$response_arr['isSuccess'] = false;
			$response_arr['message'] = 'Invalid.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}else{
			$response_arr = array();
			$response_arr['data'] = json_encode($result);
			$response_arr['status'] = 200;
			$response_arr['isSuccess'] = true;
			$response_arr['message'] = 'Valid.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}
	}
	
	public function contestListing(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		$orderBy = $post_data->request->orderBy;
		
		$result = $this->contest_model->getAllOpenContests($customerId,$orderBy);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function runningContestListing(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		
		$result = $this->contest_model->getAllRunningContests($customerId);
		
		$response_arr = array();
		$response_arr['data'] = json_encode($result);
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function completedContestListing(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		
		$result = $this->contest_model->getAllCompletedContests($customerId);
		
		$response_arr = array();
		$response_arr['data'] = json_encode($result);
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function getZonesByContestId(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$contestId = $post_data->request->contestId;
		
		$result = $this->contest_model->getZonesByContestId($contestId);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function getCompaniesByContestIdAndZoneId(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$contestId = $post_data->request->contestId;
		$zoneId = $post_data->request->zoneId;
		
		$result = $this->contest_model->getCompaniesByContestIdAndZoneId($contestId,$zoneId);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function getCompaniesByContestIdAndCustomerId(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$contestId = $post_data->request->contestId;
		$customerId = $post_data->request->customerId;
		
		$result = $this->contest_model->getCompaniesByContestIdAndCustomerId($contestId,$customerId);
		
		$response_arr = array();
		$response_arr['data'] = json_encode($result);
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function joinContest(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$CustomerID = $post_data->request->userId;
		$ContestID = $post_data->request->contestId;
		$CompanyIDDiamond = $post_data->request->diamondCompany;
		$CompanyIDPlatinum = $post_data->request->platinumCompany;
		$CompanyIDSelected = $post_data->request->selectedCompany;
		
		$customer_data = $this->customer_model->getcustomerInfo($CustomerID);
		$customer_Amount = $customer_data[0]->Amount;
		
		$contest_data = $this->contest_model->getcontestInfo($ContestID);
		$ContestEntryFees = $contest_data[0]->ContestEntryFees;
		
		if($customer_Amount<$ContestEntryFees){
			$response_arr = array();
			$response_arr['data'] = array('CustomerID'=>$CustomerID,'ContestID'=>$ContestID,'CompanyIDDiamond'=>$CompanyIDDiamond,'CompanyIDPlatinum'=>$CompanyIDPlatinum,'CompanyIDSelected'=>$CompanyIDSelected);
			$response_arr['status'] = 200;
			$response_arr['isSuccess'] = false;
			$response_arr['message'] = 'There is insufficient funds in your account.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}else{
			$customer_Amount = $customer_Amount-$ContestEntryFees;
			$customerInfo = array('Amount'=>$customer_Amount);
			$this->customer_model->customerEntryFeesEdit($CustomerID,$customerInfo);
			
			for($i=0;$i<count($CompanyIDSelected);$i++){
				if($CompanyIDSelected[$i]->companyId==$CompanyIDPlatinum){
					$customerteamInfo = array('ContestID'=>$ContestID,
											  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
											  'CustomerID'=>$CustomerID,
											  'IsPrimaryCompany'=>'1',
											  'IsSecondaryCompany'=>'0',
											  'Status'=>'0',
											  'UpdatedOn'=>date('Y-m-d H:i:s')
										);
					$this->contest_model->customerteamInsert($customerteamInfo);
				}else if($CompanyIDSelected[$i]->companyId==$CompanyIDDiamond){
					$customerteamInfo = array('ContestID'=>$ContestID,
											  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
											  'CustomerID'=>$CustomerID,
											  'IsPrimaryCompany'=>'0',
											  'IsSecondaryCompany'=>'1',
											  'Status'=>'0',
											  'UpdatedOn'=>date('Y-m-d H:i:s')
										);
					$this->contest_model->customerteamInsert($customerteamInfo);
				}else{
					$customerteamInfo = array('ContestID'=>$ContestID,
											  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
											  'CustomerID'=>$CustomerID,
											  'IsPrimaryCompany'=>'0',
											  'IsSecondaryCompany'=>'0',
											  'Status'=>'0',
											  'UpdatedOn'=>date('Y-m-d H:i:s')
										);
					$this->contest_model->customerteamInsert($customerteamInfo);
				}
			}
			
			$ContestSpotsAvailable = $contest_data[0]->ContestSpotsAvailable-1;
			$ContestSpotsJoined = $contest_data[0]->ContestSpotsTotal-$ContestSpotsAvailable;
			$ContestFinalPrizePool = ($contest_data[0]->ContestEntryFees/$ContestSpotsJoined)/(1+($contest_data[0]->Zero2CroreMargin/100));
			
			$contestInfo = array('ContestSpotsAvailable'=>$ContestSpotsAvailable,
								 'ContestSpotsJoined'=>$ContestSpotsJoined,
								 'ContestFinalPrizePool'=>$ContestFinalPrizePool
								);
			$this->contest_model->contestJoiningEdit($ContestID,$contestInfo);
				
			$response_arr = array('CustomerID'=>$CustomerID,'ContestID'=>$ContestID,'CompanyIDDiamond'=>$CompanyIDDiamond,'CompanyIDPlatinum'=>$CompanyIDPlatinum,'CompanyIDSelected'=>$CompanyIDSelected);
			$response_arr['data'] = '';
			$response_arr['status'] = 200;
			$response_arr['isSuccess'] = true;
			$response_arr['message'] = 'You have successfully joined the contest.';
			
			$response_json = json_encode($response_arr);
			echo $response_json;
		}
	}
	
	public function editCustomerContestTeam(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$CustomerID = $post_data->request->userId;
		$ContestID = $post_data->request->contestId;
		$CompanyIDDiamond = $post_data->request->diamondCompany;
		$CompanyIDPlatinum = $post_data->request->platinumCompany;
		$CompanyIDSelected = $post_data->request->selectedCompany;
		
		$this->contest_model->customerTeamJoiningEdit($ContestID,$CustomerID,array('Status'=>'1'));
		
		for($i=0;$i<count($CompanyIDSelected);$i++){
			if($CompanyIDSelected[$i]->companyId==$CompanyIDPlatinum){
				$customerteamInfo = array('ContestID'=>$ContestID,
										  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
										  'CustomerID'=>$CustomerID,
										  'IsPrimaryCompany'=>'1',
										  'IsSecondaryCompany'=>'0',
										  'Status'=>'0',
										  'UpdatedOn'=>date('Y-m-d H:i:s')
									);
				$this->contest_model->customerteamInsert($customerteamInfo);
			}else if($CompanyIDSelected[$i]->companyId==$CompanyIDDiamond){
				$customerteamInfo = array('ContestID'=>$ContestID,
										  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
										  'CustomerID'=>$CustomerID,
										  'IsPrimaryCompany'=>'0',
										  'IsSecondaryCompany'=>'1',
										  'Status'=>'0',
										  'UpdatedOn'=>date('Y-m-d H:i:s')
									);
				$this->contest_model->customerteamInsert($customerteamInfo);
			}else{
				$customerteamInfo = array('ContestID'=>$ContestID,
										  'CompanyID'=>$CompanyIDSelected[$i]->companyId,
										  'CustomerID'=>$CustomerID,
										  'IsPrimaryCompany'=>'0',
										  'IsSecondaryCompany'=>'0',
										  'Status'=>'0',
										  'UpdatedOn'=>date('Y-m-d H:i:s')
									);
				$this->contest_model->customerteamInsert($customerteamInfo);
			}
		}
		
		$response_arr = array('CustomerID'=>$CustomerID,'ContestID'=>$ContestID,'CompanyIDDiamond'=>$CompanyIDDiamond,'CompanyIDPlatinum'=>$CompanyIDPlatinum,'CompanyIDSelected'=>$CompanyIDSelected);
		$response_arr['data'] = '';
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		$response_arr['message'] = 'You have successfully edited the contest.';
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function editJoinedContestTeam(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$CustomerID = $post_data->request->userId;
		$ContestID = $post_data->request->contestId;
		
		$result_customer_team = $this->contest_model->getCustomerTeamInfo($CustomerID,$ContestID);
		$result_ContestCompanyZonePoint = $this->contest_model->getContestCompanyZonePointInfo($ContestID);
		
		$joined_company_array = array();
		$platinum='';
		$diamond='';
		for($i=0;$i<count($result_customer_team);$i++){
			if($result_customer_team[$i]->IsPrimaryCompany=='1'){
				$platinum = $result_customer_team[$i]->CompanyID;
			}
			if($result_customer_team[$i]->IsSecondaryCompany=='1'){
				$diamond = $result_customer_team[$i]->CompanyID;
			}
			$joined_company_array[] = $result_customer_team[$i]->CompanyID;
		}
		
		$main_array = array();
		$main_array['response']['userId'] = $CustomerID;
		$main_array['response']['contestId'] = $ContestID;
		$main_array['response']['platinum'] = $platinum;
		$main_array['response']['diamond'] = $diamond;
		
		$count = 0;
		$zone_arr = array();
		for($i=0;$i<count($result_ContestCompanyZonePoint);$i++){
			if(!array_key_exists($result_ContestCompanyZonePoint[$i]['zoneId'],$zone_arr)){
				if(empty($zone_arr)){
					$zone_arr[$result_ContestCompanyZonePoint[$i]['zoneId']] = $count;
				}else{
					$zone_arr[$result_ContestCompanyZonePoint[$i]['zoneId']] = $count+1;
				}
			}
		}
		//print_r($zone_arr); die();
		$zonewise_joined_company_array = array();
		for($i=0;$i<count($result_ContestCompanyZonePoint);$i++){
			$company_id = $result_ContestCompanyZonePoint[$i]['companyId'];
			if(in_array($company_id,$joined_company_array)){
				$zonewise_joined_company_array[$zone_arr[$result_ContestCompanyZonePoint[$i]['zoneId']]]['zoneName'] = $result_ContestCompanyZonePoint[$i]['ZoneName'];
				$zonewise_joined_company_array[$zone_arr[$result_ContestCompanyZonePoint[$i]['zoneId']]]['zoneID'] = $result_ContestCompanyZonePoint[$i]['zoneId'];
				$zonewise_joined_company_array[$zone_arr[$result_ContestCompanyZonePoint[$i]['zoneId']]]['company'][] = array('companyID'=>$result_ContestCompanyZonePoint[$i]['companyId'],'companyName'=>$result_ContestCompanyZonePoint[$i]['CompanyName'],'companyPoint'=>$result_ContestCompanyZonePoint[$i]['companyPoint']);
			}
		}
		
		$main_array['response']['companyZoneList'] = $zonewise_joined_company_array;
		 
		$response_arr['data'] = $main_array;
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function getRunningCompletedContest(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'));
		
		$customerId = $post_data->request->userId;
		$contestId = $post_data->request->contestId;
		$closingStatus = $post_data->request->closingStatus;
		
		$result = $this->contest_model->getRunningCompletedContest($customerId,$contestId,$closingStatus);
		
		$response_arr = array();
		$response_arr['data'] = json_encode($result);
		$response_arr['status'] = 200;
		$response_arr['isSuccess'] = true;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	function updatePresentCompany($date){
		$result = $this->contest_model->getRunningCompaniesOnGivenDate($date);
		$company_string = implode("','",$result);
		$query = "UPDATE `company` SET `Status`='0' WHERE `ID` NOT IN ('".$company_string."')";
		$this->contest_model->dml_query($query);
		$query = "UPDATE `company` SET `Status`='1' WHERE `ID` IN ('".$company_string."')";
		$this->contest_model->dml_query($query);
		echo 'Done';
	}
	
	function gameCron()
	{
		//$current_date = '05/15/2020 09:15';
		$current_date = date("m/d/Y H:i:s");
		//echo $current_date; die();
		$current_timestamp = strtotime($current_date);
		//$current_timestamp = time();
		
		/*Picking up contests whose open date time stamp matches with or lesser than current timestamp*/
		$contest_array_upcoming = $this->contest_model->getToBeOpenedContest($current_timestamp);
		
		/*Picking up contests whose closed date time stamp matches with or lesser than current timestamp*/
		$contest_array_closed = $this->contest_model->getToBeClosedContest($current_timestamp);
		
		/*Updating the upcoming contest to running*/
		for($i=0;$i<count($contest_array_upcoming);$i++){
			$contest_info_arr = $this->contest_model->getcontestInfo($contest_array_upcoming[$i]);
			$contestSpotJoined = $contest_info_arr[0]->ContestSpotsJoined;
			if($contestSpotJoined==0){
				$this->contest_model->contestJoiningEdit($contest_array_upcoming[$i],array('ClosingStatus'=>3));
			}else{
				$this->contest_model->contestJoiningEdit($contest_array_upcoming[$i],array('ClosingStatus'=>2));
				//Rectify Prize Distribution Amount, Final prize pool
				$this->contest_model->rectifyPrizeDistributionFinalPrizePool($contest_array_upcoming[$i]);
			}
		}
		
		/*Updating the running contest to closed*/
		for($i=0;$i<count($contest_array_closed);$i++){
			$this->contest_model->contestJoiningEdit($contest_array_closed[$i],array('ClosingStatus'=>3));
			//Distribute Prie Amount
			$this->contest_model->distributePrize($contest_array_closed[$i]);
		}
		
		/*Getting contest ID array having closing status 2 or running*/
		$running_contest_ids = $this->contest_model->getContestIDsByClosingStatus(2);
		
		/*updating company scores which are in running contests at current time stamp*/
		for($i=0;$i<count($running_contest_ids);$i++){
			$contest_info_arr = $this->contest_model->getcontestInfo($running_contest_ids[$i]);
			$PSMCDT_contest = $contest_info_arr[0]->PSMCDT;
			
			$ContestCompanyZonePointInfo_arr = $this->contest_model->getContestCompanyZonePointInfo($running_contest_ids[$i]);
			
			/*Company Score Calculation for particular contest and updating in ContestCompanyZonePointInfo table*/
			$PSMCDT_contest_arr = explode(' ',$PSMCDT_contest);
			$PSMCDT_contest_core = $PSMCDT_contest_arr[0];
			
			$current_date_arr = explode(' ',$current_date);
			$current_date_core = $current_date_arr[0];
			
			for($j=0;$j<count($ContestCompanyZonePointInfo_arr);$j++){
				$company_id = $ContestCompanyZonePointInfo_arr[$j]['companyId'];
				$company_previous_cp = $this->contest_model->getCompanyPreviousCP($PSMCDT_contest_core,$company_id);
				if($company_previous_cp==''){
					$company_previous_cp=0;
				}
				//echo $company_previous_cp.'<br>'; die();
				$company_present_cp = $this->contest_model->getCompanyPresentCP($current_date_core,$company_id);
				if($company_present_cp==''){
					$company_present_cp=0;
				}
				//echo $company_present_cp.'<br>';
				if($company_previous_cp==0){
					$score=0;
				}else{
					$score = (($company_present_cp-$company_previous_cp)/$company_previous_cp)*1000;
					$score = round($score,2);
				}
				$this->contest_model->update_score($running_contest_ids[$i],$company_id,$score);
			}
			//echo 'test'; die();
			$this->contest_model->generate_rank($running_contest_ids[$i]);
		}
	}
	
	function fillCompanyContest(){
		$this->contest_model->fillCompanyContest();
	}
	
	function test(){//3019
		$current_date = date("m/d/Y H:i:s");
		$current_date_arr = explode(' ',$current_date);
		$current_date_core = $current_date_arr[0];
		$company_previous_cp = $this->contest_model->getCompanyPreviousCP('05/18/2020','5079');
		$company_present_cp = $this->contest_model->getCompanyPresentCP($current_date_core,'5079');
		
		$score = (($company_present_cp-$company_previous_cp)/$company_previous_cp)*1000;
		
		echo $score;
	}
	
	function testupdate(){
		$this->contest_model->testupdate();
	}
	
}
?>