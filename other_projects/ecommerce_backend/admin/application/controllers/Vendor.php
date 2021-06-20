<?php if(!defined('BASEPATH')){
	exit('No direct script access allowed');
}	

require APPPATH . '/libraries/BaseController.php';

class Vendor extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('vendor_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
		
		$this->load->helper('email');
	}

	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the Vendor list
     */
    function vendorListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('vendor_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->vendor_model->vendorListingCount($searchText);

			$returns = $this->paginationCompress( "vendorListing/", $count, 5 );
            
            $data['vendorRecords'] = $this->vendor_model->vendorListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Vendor Listing';
            
            $this->loadViews("vendor", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewVendor()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('vendor_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New vendor';
			$data=array();

            $this->loadViews("addNewVendor", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor to the system
     */
    function postVendor()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            $this->form_validation->set_rules('contact_number','Contact Number','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('address','Address','trim|required|xss_clean');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewVendor();
            }
            else
            {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$address = $this->input->post('address');
                
                $vendorInfo = array(
				                     'name'=>$name,
									 'contact_number'=>$contact_number, 
								     'email'=>$email, 
									 'address'=>$address, 
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                $this->load->model('vendor_model');
                $result = $this->vendor_model->addNewVendor($vendorInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New vendor created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vendor creation failed');
                }
                
                redirect('addNewVendor');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the vendor using vendor id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusVendor()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$vendor_arr = $this->vendor_model->getVendorInfo($id);
			
			$status = $vendor_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $vendorInfo = array(
			'status'=>$statusVal,
			'updated_by'=>$this->vendorId, 
			'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->vendor_model->changeStatusVendor($id, $vendorInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor edit information
     * @param number $id : Optional : This is vendor id
     */
    function editVendorOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('vendorListing');
            }
            
            $data['vendorInfo'] = $this->vendor_model->getVendorInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit vendor';
            
            $this->loadViews("editVendorOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor view information
     * @param number $id : Optional : This is vendor id
     */
    function viewVendorOld($id = null)
    {
        if($this->isAdmin() == true)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('vendorListing');
            }
            
            $data['vendorInfo'] = $this->vendor_model->getVendorInfo($id);
			
			$created_by = $data['vendorInfo'][0]->created_by;
			$updated_by = $data['vendorInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['vendorInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['vendorInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View vendor';
            
            $this->loadViews("viewVendorOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor information
     */
    function editVendor()
    {
        if($this->isAdmin() == true)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
			
            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            $this->form_validation->set_rules('contact_number','Contact Number','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('address','Address','trim|required|xss_clean');
            
            if($this->form_validation->run() == false)
            {
                $this->editOld($id);
            }
            else
            {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$address = $this->input->post('address');
                
                $vendorInfo = array();
                
                 $vendorInfo = array(
				                     'name'=>$name,
									 'contact_number'=>$contact_number, 
								     'email'=>$email, 
									 'address'=>$address, 
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                
                $result = $this->vendor_model->editVendor($vendorInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Vendor updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vendor updation failed');
                }
                
                redirect('vendorListing');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor already exist or not
     */
    function checkVendorExists()
    {
        $id = $this->input->post("id");
        $email = $this->input->post("email");

        if(empty($id)){
            $result = $this->vendor_model->checkVendorExists($email);
        } else {
            $result = $this->vendor_model->checkVendorExists($email, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>