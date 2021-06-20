<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Customer extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the customer list
     */
    function customerListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('customer_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->customer_model->customerListingCount($searchText);

			$returns = $this->paginationCompress( "customer/", $count, 5 );
            
            $data['customerRecords'] = $this->customer_model->customerListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Customer Listing';
            
            $this->loadViews("customer", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('customer_model');
            
            $this->global['pageTitle'] = 'CodeInsect : Add New Customer';
			$data=array();

            $this->loadViews("addNewCustomer", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new customer to the system
     */
    function postCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('FirstName','First Name','trim|required|xss_clean');
            $this->form_validation->set_rules('LastName','Last Name','trim|required|xss_clean');
            $this->form_validation->set_rules('MobileNumber','Mobile Number','trim|required|xss_clean');
			$this->form_validation->set_rules('EmailAddress','Email Address','trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('PanNumber','Pan Number','trim|required|xss_clean');
			$this->form_validation->set_rules('AadharNumber','Aadhar Number','trim|required|xss_clean');
			$this->form_validation->set_rules('Password','Password','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewCustomer();
            }
            else
            {
                $FirstName = $this->input->post('FirstName');
				$LastName = $this->input->post('LastName');
				$MobileNumber = $this->input->post('MobileNumber');
				$EmailAddress = $this->input->post('EmailAddress');
				$PanNumber = $this->input->post('PanNumber');
				$AadharNumber = $this->input->post('AadharNumber');
				$Password = $this->input->post('Password');
				$CustomerAddress = $this->input->post('CustomerAddress');
				$CustomerCity = $this->input->post('CustomerCity');
				$CustomerState = $this->input->post('CustomerState');
				$CustomerCountry = $this->input->post('CustomerCountry');
				$CustomerPincode = $this->input->post('CustomerPincode');
				$CustomerBankName = $this->input->post('CustomerBankName');
				$CustomerBankAccountNumber = $this->input->post('CustomerBankAccountNumber');
				$CustomerBankIfsc = $this->input->post('CustomerBankIfsc');
				$CustomerAccountVerificationStatus = $this->input->post('CustomerAccountVerificationStatus');
				$CustomerBankVerificationDate = $this->input->post('CustomerBankVerificationDate');
				$CustomerPANVerificationStatus = $this->input->post('CustomerPANVerificationStatus');
				$CustomerPANVerificationDate = $this->input->post('CustomerPANVerificationDate');
				
				$config['upload_path']          = 'uploads/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 1000000;
                $config['max_width']            = 1024000;
                $config['max_height']           = 7680000;
				
				$this->load->library('upload', $config);
				
				$base_path = str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']);
				
				if(!$this->upload->do_upload('PanCardFile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						//print_r($error); die();
                }
                else
                {
                        $upload_data = array('upload_data' => $this->upload->data());
						$PanCardFile = $upload_data['upload_data']['full_path'];
						$PanCardFile = str_replace($base_path,base_url(),$PanCardFile);
                }
				
				if(!$this->upload->do_upload('BankProofFile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						//print_r($error); die();
                }
                else
                {
                        $upload_data = array('upload_data' => $this->upload->data());
						$BankProofFile = $upload_data['upload_data']['full_path'];
						$BankProofFile = str_replace($base_path,base_url(),$PanCardFile);
                }
            
                $customerInfo = array('FirstName'=>$FirstName,
									 'LastName'=>$LastName,
									 'UserName'=>$EmailAddress,
									 'Password'=>$Password,
									 'MobileNumber'=>$MobileNumber,
									 'EmailAddress'=>$EmailAddress,
									 'PanNumber'=>$PanNumber,
									 'AadharNumber'=>$AadharNumber,
									 'MobileVerificationStatus'=>'1',
									 'MobileVerificationCode'=>'',
									 'EmailVerificationStatus'=>'1',
									 'EmailVerificationCode'=>'',
									 'FacebookLinkedAccount'=>'0',
									 'FacebookAccountEmailAddress'=>'',
									 'GoogleLinkedAccount'=>'0',
									 'GoogleAccountEmailAddress'=>'',
									 'createdBy'=>$this->vendorId,
									 'updatedBy'=>$this->vendorId, 
									 'createdOn'=>date('Y-m-d H:i:s'), 
									 'updatedOn'=>date('Y-m-d H:i:s')
									 );
				$customerDetailsInfo = array('CustomerAddress'=>$CustomerAddress,
									 'CustomerCity'=>$CustomerCity,
									 'CustomerState'=>$CustomerState,
									 'CustomerCountry'=>$CustomerCountry,
									 'CustomerPincode'=>$CustomerPincode,
									 'CustomerBankName'=>$CustomerBankName,
									 'CustomerBankAccountNumber'=>$CustomerBankAccountNumber,
									 'CustomerBankIfsc'=>$CustomerBankIfsc,
									 'CustomerAccountVerificationStatus'=>$CustomerAccountVerificationStatus,
									 'CustomerBankVerificationDate'=>$CustomerBankVerificationDate,
									 'CustomerPANVerificationStatus'=>$CustomerPANVerificationStatus,
									 'CustomerPANVerificationDate'=>$CustomerPANVerificationDate,
									 'PanNumber'=>$PanNumber
									 );
				$customerPanFileInfo = array('PanCardFile'=>$PanCardFile,
									 'UploadDate'=>date('Y/m/d H:i:s')
									   );
				$customerBankProofFileInfo = array('BankProofFile'=>$BankProofFile,
									 'UploadDate'=>date('Y/m/d H:i:s')
									   );
                
                $this->load->model('customer_model');
                $result = $this->customer_model->addNewCustomer($customerInfo,$customerDetailsInfo,$customerPanFileInfo,$customerBankProofFileInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Customer created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Customer creation failed');
                }
                
                redirect('addNewCustomer');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the customer using customerId
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $customerId = $this->input->post('customerId');
			
			$customer_arr = $this->customer_model->getCustomerInfo($customerId);
			
			$status = $customer_arr[0]->Status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $customerInfo = array('Status'=>$statusVal,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
            
            $result = $this->customer_model->changeStatusCustomer($customerId, $customerInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load customer edit information
     * @param number $customerId : Optional : This is customer id
     */
    function editCustomerOld($customerId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($customerId == null)
            {
                redirect('customerListing');
            }
            
            $data['customerInfo'] = $this->customer_model->getCustomerInfo($customerId);
			$data['customerDetailsInfo'] = $this->customer_model->getCustomerDetailsInfo($customerId);
			$data['customerPanFileInfo'] = $this->customer_model->getCustomerPanFileInfo($customerId);
			$data['customerBankProofFileInfo'] = $this->customer_model->getCustomerBankProofFileInfo($customerId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Customer';
            
            $this->loadViews("editCustomerOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load customer view information
     * @param number $customerId : Optional : This is customer id
     */
    function viewCustomerOld($customerId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($customerId == null)
            {
                redirect('customerListing');
            }
            
            $data['customerInfo'] = $this->customer_model->getCustomerInfo($customerId);
			$data['customerDetailsInfo'] = $this->customer_model->getCustomerDetailsInfo($customerId);
			$data['customerPanFileInfo'] = $this->customer_model->getCustomerPanFileInfo($customerId);
			$data['customerBankProofFileInfo'] = $this->customer_model->getCustomerBankProofFileInfo($customerId);
			
			$createdByID = $data['customerInfo'][0]->createdBy;
			$updatedByID = $data['customerInfo'][0]->updatedBy;
			
			$createdByUserArray = $this->user_model->getUserInfo($createdByID);
			
			$data['customerInfo'][0]->createdBy = $createdByUserArray[0]->email;
			
			$updatedByUserArray = $this->user_model->getUserInfo($updatedByID);
			$data['customerInfo'][0]->updatedBy = $updatedByUserArray[0]->email;
            
            $this->global['pageTitle'] = 'CodeInsect : View Customer';
            
            $this->loadViews("viewCustomerOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the customer information
     */
    function editCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $customerId = $this->input->post('ID');
            
            $this->form_validation->set_rules('FirstName','First Name','trim|required|xss_clean');
            $this->form_validation->set_rules('LastName','Last Name','trim|required|xss_clean');
            $this->form_validation->set_rules('PanNumber','Pan Number','trim|required|xss_clean');
			$this->form_validation->set_rules('AadharNumber','Aadhar Number','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($customerId);
            }
            else
            {
                $FirstName = $this->input->post('FirstName');
				$LastName = $this->input->post('LastName');
				$PanNumber = $this->input->post('PanNumber');
				$AadharNumber = $this->input->post('AadharNumber');
				$CustomerAddress = $this->input->post('CustomerAddress');
				$CustomerCity = $this->input->post('CustomerCity');
				$CustomerState = $this->input->post('CustomerState');
				$CustomerCountry = $this->input->post('CustomerCountry');
				$CustomerPincode = $this->input->post('CustomerPincode');
				$CustomerBankName = $this->input->post('CustomerBankName');
				$CustomerBankAccountNumber = $this->input->post('CustomerBankAccountNumber');
				$CustomerBankIfsc = $this->input->post('CustomerBankIfsc');
				$CustomerAccountVerificationStatus = $this->input->post('CustomerAccountVerificationStatus');
				$CustomerBankVerificationDate = $this->input->post('CustomerBankVerificationDate');
				$CustomerPANVerificationStatus = $this->input->post('CustomerPANVerificationStatus');
				$CustomerPANVerificationDate = $this->input->post('CustomerPANVerificationDate');
				
				$config['upload_path']          = 'uploads/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 1000000;
                $config['max_width']            = 1024000;
                $config['max_height']           = 7680000;
				
				$this->load->library('upload', $config);
				
				$base_path = str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']);
				
				if(!$this->upload->do_upload('PanCardFile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						//print_r($error); die();
                }
                else
                {
                        $upload_data = array('upload_data' => $this->upload->data());
						$PanCardFile = $upload_data['upload_data']['full_path'];
						$PanCardFile = str_replace($base_path,base_url(),$PanCardFile);
                }
				
				if(!$this->upload->do_upload('BankProofFile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						//print_r($error); die();
                }
                else
                {
                        $upload_data = array('upload_data' => $this->upload->data());
						$BankProofFile = $upload_data['upload_data']['full_path'];
						$BankProofFile = str_replace($base_path,base_url(),$PanCardFile);
                }
				
                $customerInfo = array('FirstName'=>$FirstName,
									 'LastName'=>$LastName,
									 'PanNumber'=>$PanNumber,
									 'AadharNumber'=>$AadharNumber,
									 'updatedBy'=>$this->vendorId, 
									 'updatedOn'=>date('Y-m-d H:i:s'));
				$customerDetailsInfo = array('CustomerAddress'=>$CustomerAddress,
									 'CustomerCity'=>$CustomerCity,
									 'CustomerState'=>$CustomerState,
									 'CustomerCountry'=>$CustomerCountry,
									 'CustomerPincode'=>$CustomerPincode,
									 'CustomerBankName'=>$CustomerBankName,
									 'CustomerBankAccountNumber'=>$CustomerBankAccountNumber,
									 'CustomerBankIfsc'=>$CustomerBankIfsc,
									 'CustomerAccountVerificationStatus'=>$CustomerAccountVerificationStatus,
									 'CustomerBankVerificationDate'=>$CustomerBankVerificationDate,
									 'CustomerPANVerificationStatus'=>$CustomerPANVerificationStatus,
									 'CustomerPANVerificationDate'=>$CustomerPANVerificationDate,
									 'PanNumber'=>$PanNumber
									 );
				$customerPanFileInfo = array('PanCardFile'=>$PanCardFile,
									 'UploadDate'=>date('Y/m/d H:i:s')
									   );
				$customerBankProofFileInfo = array('BankProofFile'=>$BankProofFile,
									 'UploadDate'=>date('Y/m/d H:i:s')
									   );
                
                $result = $this->customer_model->editCustomer($customerInfo, $customerDetailsInfo, $customerPanFileInfo, $customerBankProofFileInfo, $customerId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Customer updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Customer updation failed');
                }
                
                redirect('customerListing');
            }
        }
    }
	
	/**
     * This function is used to check whether customer already exist or not
     */
    function checkCustomerExists()
    {
        $customerId = $this->input->post("ID");
        $EmailAddress = $this->input->post("EmailAddress");
		$MobileNumber = $this->input->post("MobileNumber");
		$PanNumber = $this->input->post("PanNumber");
		$AadharNumber = $this->input->post("AadharNumber");

        if(empty($customerId)){
            $result = $this->customer_model->checkCustomerExistsNew($EmailAddress, $MobileNumber, $PanNumber, $AadharNumber);
        } else {
            $result = $this->customer_model->checkCustomerExistsNew($EmailAddress, $MobileNumber, $PanNumber, $AadharNumber, $customerId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>