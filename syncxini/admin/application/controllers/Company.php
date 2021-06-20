<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Company extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the company list
     */
    function companyListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('company_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->company_model->companyListingCount($searchText);

			$returns = $this->paginationCompress( "company/", $count, 5 );
            
            $data['companyRecords'] = $this->company_model->companyListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Company Listing';
            
            $this->loadViews("company", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the company history list
     */
    function companyHistoryListing($companyId=NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
		{
			if($companyId == null)
            {
                redirect('companyListing');
            }
			
            $this->load->model('company_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->company_model->companyHistoryListingCount($searchText,$companyId);

			$returns = $this->paginationCompress( "company/", $count, 50 );
            
            $data['companyHistoryRecords'] = $this->company_model->companyHistoryListing($searchText, $returns["page"], $returns["segment"],$companyId);
			//print_r($data); die();
			$data['companyID'] = $companyId;
			
			$companyInfo = $this->company_model->getCompanyInfo($companyId);
			//print_r($companyInfo[0]); die();
			$data['companyName'] = $companyInfo[0]->CompanyName;
			
            $this->global['pageTitle'] = 'CodeInsect : Company History Listing';
            
            $this->loadViews("companyHistory", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewCompany()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('company_model');
            
            $this->global['pageTitle'] = 'CodeInsect : Add New Company';
			$data=array();

            $this->loadViews("addNewCompany", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new company to the system
     */
    function postCompany()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('CompanyName','Company Name','trim|required|xss_clean');
            $this->form_validation->set_rules('CompanyCode','Company Code','trim|required|xss_clean');
			$this->form_validation->set_rules('InstrumentToken','Instrument Token','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ExchangeToken','Exchange Token','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('InstrumentType','Instrument Type','trim|required|xss_clean');
			$this->form_validation->set_rules('Segment','Segment','trim|required|xss_clean');
			$this->form_validation->set_rules('Exchange','Exchange','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewCompany();
            }
            else
            {
                $CompanyName = $this->input->post('CompanyName');
				$CompanyCode = $this->input->post('CompanyCode');
				$InstrumentToken = $this->input->post('InstrumentToken');
				$ExchangeToken = $this->input->post('ExchangeToken');
				$InstrumentType = $this->input->post('InstrumentType');
				$Segment = $this->input->post('Segment');
				$Exchange = $this->input->post('Exchange');
                
                $companyInfo = array('CompanyName'=>$CompanyName,
									 'CompanyCode'=>$CompanyCode, 
									 'InstrumentToken'=>$InstrumentToken, 
									 'ExchangeToken'=> $ExchangeToken,
                                     'InstrumentType'=>$InstrumentType, 
									 'Segment'=>$Segment, 'Exchange'=>$Exchange, 
									 'createdBy'=>$this->vendorId,
									 'updatedBy'=>$this->vendorId, 
									 'createdOn'=>date('Y-m-d H:i:s'), 
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $this->load->model('company_model');
                $result = $this->company_model->addNewCompany($companyInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Company created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Company creation failed');
                }
                
                redirect('addNewCompany');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the company using companyId
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCompany()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $companyId = $this->input->post('companyId');
			
			$company_arr = $this->company_model->getCompanyInfo($companyId);
			
			$status = $company_arr[0]->Status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $companyInfo = array('Status'=>$statusVal,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
            
            $result = $this->company_model->changeStatusCompany($companyId, $companyInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load company edit information
     * @param number $companyId : Optional : This is company id
     */
    function editCompanyOld($companyId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($companyId == null)
            {
                redirect('companyListing');
            }
            
            $data['companyInfo'] = $this->company_model->getCompanyInfo($companyId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Company';
            
            $this->loadViews("editCompanyOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load company view information
     * @param number $companyId : Optional : This is company id
     */
    function viewCompanyOld($companyId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($companyId == null)
            {
                redirect('companyListing');
            }
            
            $data['companyInfo'] = $this->company_model->getCompanyInfo($companyId);
			
			$createdByID = $data['companyInfo'][0]->createdBy;
			$updatedByID = $data['companyInfo'][0]->updatedBy;
			
			$createdByUserArray = $this->user_model->getUserInfo($createdByID);
			
			$data['companyInfo'][0]->createdBy = $createdByUserArray[0]->email;
			
			$updatedByUserArray = $this->user_model->getUserInfo($updatedByID);
			$data['companyInfo'][0]->updatedBy = $updatedByUserArray[0]->email;
            
            $this->global['pageTitle'] = 'CodeInsect : View Company';
            
            $this->loadViews("viewCompanyOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the company information
     */
    function editCompany()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $companyId = $this->input->post('ID');
            
            $this->form_validation->set_rules('CompanyName','Company Name','trim|required|xss_clean');
            $this->form_validation->set_rules('CompanyCode','Company Code','trim|required|xss_clean');
			$this->form_validation->set_rules('InstrumentToken','Instrument Token','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ExchangeToken','Exchange Token','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('InstrumentType','Instrument Type','trim|required|xss_clean');
			$this->form_validation->set_rules('Segment','Segment','trim|required|xss_clean');
			$this->form_validation->set_rules('Exchange','Exchange','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($companyId);
            }
            else
            {
                $CompanyName = $this->input->post('CompanyName');
				$CompanyCode = $this->input->post('CompanyCode');
				$InstrumentToken = $this->input->post('InstrumentToken');
				$ExchangeToken = $this->input->post('ExchangeToken');
				$InstrumentType = $this->input->post('InstrumentType');
				$Segment = $this->input->post('Segment');
				$Exchange = $this->input->post('Exchange');
                
                $companyInfo = array();
                
                $companyInfo = array('CompanyName'=>$CompanyName,
									 'CompanyCode'=>$CompanyCode, 
									 'InstrumentToken'=>$InstrumentToken, 
									 'ExchangeToken'=> $ExchangeToken,
                                     'InstrumentType'=>$InstrumentType, 
									 'Segment'=>$Segment, 'Exchange'=>$Exchange,
									 'updatedBy'=>$this->vendorId,  
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $result = $this->company_model->editCompany($companyInfo, $companyId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Company updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Company updation failed');
                }
                
                redirect('companyListing');
            }
        }
    }
	
	/**
     * This function is used to check whether company already exist or not
     */
    function checkCompanyExists()
    {
        $companyId = $this->input->post("ID");
        $CompanyCode = $this->input->post("CompanyCode");

        if(empty($companyId)){
            $result = $this->company_model->checkCompanyExists($CompanyCode);
        } else {
            $result = $this->company_model->checkCompanyExists($CompanyCode, $companyId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>