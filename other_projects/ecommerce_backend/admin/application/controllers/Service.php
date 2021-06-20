<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Service  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('service_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the service list
     */
    function serviceListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('service_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->service_model->serviceListingCount($searchText);

			$returns = $this->paginationCompress( "serviceListing/", $count, 5 );
            
            $data['serviceRecords'] = $this->service_model->serviceListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Service Listing';
            
            $this->loadViews("service", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewService()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('service_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Service ';
			$data=array();

            $this->loadViews("addNewService", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new service to the system
     */
    function postService()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewService();
            }
            else
            {
                $name = $this->input->post('name');
				
                
                $serviceInfo = array('name'=>$name,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                $this->load->model('service_model');
                $result = $this->service_model->addNewService($serviceInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New service created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Service creation failed');
                }
                
                redirect('addNewService');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the service using service Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusService()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$service_arr = $this->service_model->getServiceInfo($id);
			
			$status = $service_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $serviceInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->service_model->changeStatusService($id, $serviceInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load service edit information
     * @param number $id : Optional : This is service id
     */
    function editServiceOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('serviceListing');
            }
            
            $data['serviceInfo'] = $this->service_model->getServiceInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit service';
            
            $this->loadViews("editServiceOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load service view information
     * @param number $id : Optional : This is service id
     */
    function viewServiceOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('serviceListing');
            }
            
            $data['serviceInfo'] = $this->service_model->getServiceInfo($id);
			
			$created_by = $data['serviceInfo'][0]->created_by;
			$updated_by = $data['serviceInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['serviceInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['serviceInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Service';
            
            $this->loadViews("viewServiceOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the service information
     */
    function editService()
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
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editServiceOld($id);
            }
            else
            {
                $name = $this->input->post('name');
				
                $serviceInfo = array();
                
                $serviceInfo = array('name'=>$name,
									 'status'=>$status,
									 'created_by'=>$created_by,
									 'updated_by'=>$updated_by,
									 'updated_on'=>$this->vendorId,  
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                $result = $this->service_model->editService($serviceInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Service updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Service updation failed');
                }
                
                redirect('serviceListing');
            }
        }
    }
	
	/**
     * This function is used to check whether service already exist or not
     */
    function checkServiceExists()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");

        if(empty($id)){
            $result = $this->service_model->checkServiceExists($name);
        } else {
            $result = $this->service_model->checkServiceExists($name, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>