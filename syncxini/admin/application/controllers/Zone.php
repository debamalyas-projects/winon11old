<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Zone extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('zone_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the zone list
     */
    function zoneListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('zone_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->zone_model->zoneListingCount($searchText);

			$returns = $this->paginationCompress( "zone/", $count, 5 );
            
            $data['zoneRecords'] = $this->zone_model->zoneListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Zone Listing';
            
            $this->loadViews("zone", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewZone()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('zone_model');
            
            $this->global['pageTitle'] = 'CodeInsect : Add New Zone';
			$data=array();

            $this->loadViews("addNewZone", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new zone to the system
     */
    function postZone()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('ZoneName','Zone Name','trim|required|xss_clean');
            $this->form_validation->set_rules('ZoneOrder','Zone Order','trim|required|numeric|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewZone();
            }
            else
            {
                $ZoneName = $this->input->post('ZoneName');
				$ZoneOrder = $this->input->post('ZoneOrder');
                
                $zoneInfo = array('ZoneName'=>$ZoneName,
									 'ZoneOrder'=>$ZoneOrder, 
									 'createdBy'=>$this->vendorId,
									 'updatedBy'=>$this->vendorId, 
									 'createdOn'=>date('Y-m-d H:i:s'), 
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $this->load->model('zone_model');
                $result = $this->zone_model->addNewZone($zoneInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Zone created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zone creation failed');
                }
                
                redirect('addNewZone');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the zone using zoneId
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusZone()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $zoneId = $this->input->post('zoneId');
			
			$zone_arr = $this->zone_model->getZoneInfo($zoneId);
			
			$status = $zone_arr[0]->Status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $zoneInfo = array('Status'=>$statusVal,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
            
            $result = $this->zone_model->changeStatusZone($zoneId, $zoneInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load zone edit information
     * @param number $zoneId : Optional : This is zone id
     */
    function editZoneOld($zoneId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($zoneId == null)
            {
                redirect('zoneListing');
            }
            
            $data['zoneInfo'] = $this->zone_model->getZoneInfo($zoneId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Zone';
            
            $this->loadViews("editZoneOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load zone view information
     * @param number $zoneId : Optional : This is zone id
     */
    function viewZoneOld($zoneId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($zoneId == null)
            {
                redirect('zoneListing');
            }
            
            $data['zoneInfo'] = $this->zone_model->getZoneInfo($zoneId);
			
			$createdByID = $data['zoneInfo'][0]->createdBy;
			$updatedByID = $data['zoneInfo'][0]->updatedBy;
			
			$createdByUserArray = $this->user_model->getUserInfo($createdByID);
			
			$data['zoneInfo'][0]->createdBy = $createdByUserArray[0]->email;
			
			$updatedByUserArray = $this->user_model->getUserInfo($updatedByID);
			$data['zoneInfo'][0]->updatedBy = $updatedByUserArray[0]->email;
            
            $this->global['pageTitle'] = 'CodeInsect : View Zone';
            
            $this->loadViews("viewZoneOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the zone information
     */
    function editZone()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $zoneId = $this->input->post('ID');
            
            $this->form_validation->set_rules('ZoneName','Zone Name','trim|required|xss_clean');
            $this->form_validation->set_rules('ZoneOrder','Zone Order','trim|required|numeric|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($zoneId);
            }
            else
            {
                $ZoneName = $this->input->post('ZoneName');
				$ZoneOrder = $this->input->post('ZoneOrder');
                
                $zoneInfo = array();
                
                $zoneInfo = array('ZoneName'=>$ZoneName,
									 'ZoneOrder'=>$ZoneOrder,
									 'updatedBy'=>$this->vendorId,  
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $result = $this->zone_model->editZone($zoneInfo, $zoneId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Zone updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zone updation failed');
                }
                
                redirect('zoneListing');
            }
        }
    }
	
	/**
     * This function is used to check whether zone already exist or not
     */
    function checkZoneExists()
    {
        $zoneId = $this->input->post("ID");
        $ZoneName = $this->input->post("ZoneName");

        if(empty($zoneId)){
            $result = $this->zone_model->checkZoneExists($ZoneName);
        } else {
            $result = $this->zone_model->checkZoneExists($ZoneName, $zoneId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>