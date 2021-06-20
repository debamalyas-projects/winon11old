<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Deliverypersonmanagement extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('deliverypersonmanagement_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
		
		$this->load->helper('email');
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the deliverypersonmanagement list
     */
    function deliverypersonmanagementListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('deliverypersonmanagement_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->deliverypersonmanagement_model->deliverypersonmanagementListingCount($searchText);

			$returns = $this->paginationCompress( "deliverypersonmanagementListing/", $count, 5 );
            
            $data['deliverypersonmanagementRecords'] = $this->deliverypersonmanagement_model->deliverypersonmanagementListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Delivery Person Management Listing';
            
            $this->loadViews("deliverypersonmanagement", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewDeliverypersonmanagement()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('deliverypersonmanagement_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Delivery Person Management';
			$data=array();

            $this->loadViews("addNewDeliverypersonmanagement", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new delivery person to the system
     */
    function postDeliverypersonmanagement()
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
                $this->addNewDeliverypersonmanagement();
            }
            else
            {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$address = $this->input->post('address');
                
                $deliverypersonmanagementInfo = array(
									'name'=>$name,
									'contact_number'=>$contact_number,
									'email'=>$email,
									 'address'=>$address, 
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('deliverypersonmanagement_model');
                $result = $this->deliverypersonmanagement_model->addNewDeliverypersonmanagement($deliverypersonmanagementInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Delivery Person created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Delivery Person creation failed');
                }
                
                redirect('addNewDeliverypersonmanagement');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the delivery person using id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusDeliverypersonmanagement()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$deliverypersonmanagement_arr = $this->deliverypersonmanagement_model->getDeliverypersonmanagementInfo($id);
			
			$status = $deliverypersonmanagement_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $deliverypersonmanagementInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->deliverypersonmanagement_model->changeStatusDeliverypersonmanagement($id, $deliverypersonmanagementInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load delivery person edit information
     * @param number $id : Optional : This is delivery person id
     */
    function editDeliverypersonmanagementOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('deliverypersonmanagementListing');
            }
            
            $data['deliverypersonmanagementInfo'] = $this->deliverypersonmanagement_model->getDeliverypersonmanagementInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit Delivery Person Management';
            
            $this->loadViews("editDeliverypersonmanagementOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load delivery person view information
     * @param number $id : Optional : This is delivery person id
     */
    function viewDeliverypersonmanagementOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('deliverypersonmanagementListing');
            }
            
            $data['deliverypersonmanagementInfo'] = $this->deliverypersonmanagement_model->getDeliverypersonmanagementInfo($id);
			
			$created_by = $data['deliverypersonmanagementInfo'][0]->created_by;
			$updated_by = $data['deliverypersonmanagementInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['deliverypersonmanagementInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['deliverypersonmanagementInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Delivery Person Management';
            
            $this->loadViews("viewDeliverypersonmanagementOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the delivery person information
     */
    function editDeliverypersonmanagement()
    {
        if($this->isAdmin() == TRUE)
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
            
           
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editDeliverypersonmanagementOld($id);
            }
            else
            {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$address = $this->input->post('address');
                
                $deliverypersonmanagementInfo = array();
                
                $deliverypersonmanagementInfo = array(
									'name'=>$name,
									'contact_number'=>$contact_number,
									'email'=>$email,
									'address'=>$address, 
									'created_by'=>$this->vendorId,
									'updated_by'=>$this->vendorId, 
									'created_on'=>date('Y-m-d H:i:s'), 
									'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->deliverypersonmanagement_model->editDeliverypersonmanagement($deliverypersonmanagementInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Delivery Person updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Delivery Person updation failed');
                }
                
                redirect('deliverypersonmanagementListing');
            }
        }
    }
	
	/**
     * This function is used to check whether delivery person already exist or not
     */
    function checkDeliverypersonmanagementExists()
    {
        $id = $this->input->post("id");
        $email = $this->input->post("email");

        if(empty($id)){
            $result = $this->deliverypersonmanagement_model->checkDeliverypersonmanagementExists($email);
        } else {
            $result = $this->deliverypersonmanagement_model->checkDeliverypersonmanagementExists($email, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>