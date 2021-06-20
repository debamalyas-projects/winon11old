<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Contest extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('contest_model');
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->model('zone_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the contest list
     */
    function contestListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('contest_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->contest_model->contestListingCount($searchText);

			$returns = $this->paginationCompress( "contest/", $count, 5 );
            
            $data['contestRecords'] = $this->contest_model->contestListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Contest Listing';
            
            $this->loadViews("contest", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewContest()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('contest_model');
            
            $this->global['pageTitle'] = 'CodeInsect : Add New Contest';
			
			$company_arr = $this->company_model->companyListing();
			$zone_arr = $this->zone_model->zoneListing();
			
			$data=array(
			'company_arr'=>$company_arr,
			'zone_arr'=>$zone_arr
			);

            $this->loadViews("addNewContest", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new contest to the system
     */
    function postContest()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('ContestName','Contest Name','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestPrizePool','Contest Prize Pool','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('ContestEntryFees','Contest Entry Fees','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestSpotsTotal','Contest Spots Total','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestDate','Contest Date','trim|required|xss_clean');
			$this->form_validation->set_rules('PSMCDT','PSMCDT','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestAllowMultipleTeams','Contest Allow Multiple Teams','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestMaximumTeamAllowed','Contest Maximum Team Allowed','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestFinalPrizePool','Contest Final Prize Pool','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestOpenDateTime','Contest Open Date Time','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestCloseDateTime','Contest Close Date Time','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestVisibleToAll','Contest Visible To All','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewContest();
            }
            else
            {
                $ContestName = $this->input->post('ContestName');
				$ContestCode = time();
				$ContestPrizePool = $this->input->post('ContestPrizePool');
				$ContestEntryFees = $this->input->post('ContestEntryFees');
				$ContestSpotsTotal = $this->input->post('ContestSpotsTotal');
				$Zero2CroreMargin = $this->input->post('Zero2CroreMargin');
				$ContestDate = $this->input->post('ContestDate');
				$PSMCDT = $this->input->post('PSMCDT');
				$ContestAllowMultipleTeams = $this->input->post('ContestAllowMultipleTeams');
				$ContestMaximumTeamAllowed = $this->input->post('ContestMaximumTeamAllowed');
				$ContestFinalPrizePool = $this->input->post('ContestFinalPrizePool');
				$ContestOpenDateTime = $this->input->post('ContestOpenDateTime');
				$ContestCloseDateTime = $this->input->post('ContestCloseDateTime');
				$ContestVisibleToAll = $this->input->post('ContestVisibleToAll');
				if(!empty($this->input->post('companies'))){
					$company_arr=$this->input->post('companies');
				}else{
					$company_arr=array();
				}
				if(!empty($this->input->post('zones'))){
					$zone_arr=$this->input->post('zones');
				}else{
					$zone_arr=array();
				}
				if(!empty($this->input->post('company_points'))){
					$company_points_arr=$this->input->post('company_points');
				}else{
					$company_points_arr=array();
				}
				if(!empty($this->input->post('lower_bound_rank'))){
					$lower_bound_rank_arr=$this->input->post('lower_bound_rank');
				}else{
					$lower_bound_rank_arr=array();
				}
				if(!empty($this->input->post('upper_bound_rank'))){
					$upper_bound_rank_arr=$this->input->post('upper_bound_rank');
				}else{
					$upper_bound_rank_arr=array();
				}
				if(!empty($this->input->post('prize_money'))){
					$prize_money_arr=$this->input->post('prize_money');
				}else{
					$prize_money_arr=array();
				}
                
                $contestInfo = array('ContestName'=>$ContestName,
									 'ContestCode'=>$ContestCode,
								     'ContestPrizePool'=>$ContestPrizePool,
									 'ContestEntryFees'=>$ContestEntryFees,
								     'ContestSpotsTotal'=>$ContestSpotsTotal,
									 'Zero2CroreMargin'=>$Zero2CroreMargin,
									 'ContestSpotsAvailable'=>$ContestSpotsTotal,
									 'ContestDate'=>$ContestDate,
									 'PSMCDT'=>$PSMCDT,
								     'ContestAllowMultipleTeams'=>$ContestAllowMultipleTeams,
									 'ContestMaximumTeamAllowed'=>$ContestMaximumTeamAllowed,
								     'ContestFinalPrizePool'=>$ContestFinalPrizePool,
									 'ContestOpenDateTime'=>$ContestOpenDateTime,
								     'ContestCloseDateTime'=>$ContestCloseDateTime,
									 'ContestVisibleToAll'=>$ContestVisibleToAll,
									 'createdBy'=>$this->vendorId,
									 'updatedBy'=>$this->vendorId, 
									 'createdOn'=>date('Y-m-d H:i:s'), 
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $this->load->model('contest_model');
                $result = $this->contest_model->addNewContest($contestInfo,$zone_arr,$company_arr,$company_points_arr,$lower_bound_rank_arr,$upper_bound_rank_arr,$prize_money_arr);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Contest created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Contest creation failed');
                }
                
                redirect('addNewContest');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the contest using contestId
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusContest()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $contestId = $this->input->post('contestId');
			
			$contest_arr = $this->contest_model->getContestInfo($contestId);
			
			$status = $contest_arr[0]->Status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $contestInfo = array('Status'=>$statusVal,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
            
            $result = $this->contest_model->changeStatusContest($contestId, $contestInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load contest edit information
     * @param number $contestId : Optional : This is contest id
     */
    function editContestOld($contestId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($contestId == null)
            {
                redirect('contestListing');
            }
            
			$company_arr = $this->company_model->companyListing();
			$zone_arr = $this->zone_model->zoneListing();
			
			$data=array(
			'company_arr'=>$company_arr,
			'zone_arr'=>$zone_arr
			);
			$data['contestInfo'] = $this->contest_model->getContestInfo($contestId);
			
			$data['contestCompanyZonePointInfo'] = $this->contest_model->getContestCompanyZonePointInfo($contestId);
			$data['contestLowerBoundRankUpperBoundRankPrizrMoneyInfo'] = $this->contest_model->getContestLowerBoundRankUpperBoundRankPrizrMoneyInfo($contestId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Contest';
            
            $this->loadViews("editContestOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load contest view information
     * @param number $contestId : Optional : This is contest id
     */
    function viewContestOld($contestId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($contestId == null)
            {
                redirect('contestListing');
            }
            
            $data['contestInfo'] = $this->contest_model->getContestInfo($contestId);
			$data['contestCompanyZonePointInfo'] = $this->contest_model->getContestCompanyZonePointInfo($contestId);
			$data['contestLowerBoundRankUpperBoundRankPrizrMoneyInfo'] = $this->contest_model->getContestLowerBoundRankUpperBoundRankPrizrMoneyInfo($contestId);
			
			$createdByID = $data['contestInfo'][0]->createdBy;
			$updatedByID = $data['contestInfo'][0]->updatedBy;
			
			$createdByUserArray = $this->user_model->getUserInfo($createdByID);
			
			$data['contestInfo'][0]->createdBy = $createdByUserArray[0]->email;
			
			$updatedByUserArray = $this->user_model->getUserInfo($updatedByID);
			$data['contestInfo'][0]->updatedBy = $updatedByUserArray[0]->email;
            
            $this->global['pageTitle'] = 'CodeInsect : View Contest';
            
            $this->loadViews("viewContestOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the contest information
     */
    function editContest()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $contestId = $this->input->post('ID');
            
            $this->form_validation->set_rules('ContestName','Contest Name','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestPrizePool','Contest Prize Pool','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('ContestEntryFees','Contest Entry Fees','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('Zero2CroreMargin','Zero2Crore Margin','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestSpotsTotal','Contest Spots Total','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestDate','Contest Date','trim|required|xss_clean');
			$this->form_validation->set_rules('PSMCDT','PSMCDT','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestAllowMultipleTeams','Contest Allow Multiple Teams','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestMaximumTeamAllowed','Contest Maximum Team Allowed','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestFinalPrizePool','Contest Final Prize Pool','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('ContestOpenDateTime','Contest Open Date Time','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestCloseDateTime','Contest Close Date Time','trim|required|xss_clean');
			$this->form_validation->set_rules('ContestVisibleToAll','Contest Visible To All','trim|required|xss_clean');
			if(!empty($this->input->post('companies'))){
				$company_arr=$this->input->post('companies');
			}else{
				$company_arr=array();
			}
			if(!empty($this->input->post('zones'))){
				$zone_arr=$this->input->post('zones');
			}else{
				$zone_arr=array();
			}
			if(!empty($this->input->post('company_points'))){
				$company_points_arr=$this->input->post('company_points');
			}else{
				$company_points_arr=array();
			}
			if(!empty($this->input->post('lower_bound_rank'))){
				$lower_bound_rank_arr=$this->input->post('lower_bound_rank');
			}else{
				$lower_bound_rank_arr=array();
			}
			if(!empty($this->input->post('upper_bound_rank'))){
				$upper_bound_rank_arr=$this->input->post('upper_bound_rank');
			}else{
				$upper_bound_rank_arr=array();
			}
			if(!empty($this->input->post('prize_money'))){
				$prize_money_arr=$this->input->post('prize_money');
			}else{
				$prize_money_arr=array();
			}
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($contestId);
            }
            else
            {
                $ContestName = $this->input->post('ContestName');
				$ContestPrizePool = $this->input->post('ContestPrizePool');
				$ContestEntryFees = $this->input->post('ContestEntryFees');
				$Zero2CroreMargin = $this->input->post('Zero2CroreMargin');
				$ContestSpotsTotal = $this->input->post('ContestSpotsTotal');
				$ContestDate = $this->input->post('ContestDate');
				$PSMCDT = $this->input->post('PSMCDT');
				$ContestAllowMultipleTeams = $this->input->post('ContestAllowMultipleTeams');
				$ContestMaximumTeamAllowed = $this->input->post('ContestMaximumTeamAllowed');
				$ContestFinalPrizePool = $this->input->post('ContestFinalPrizePool');
				$ContestOpenDateTime = $this->input->post('ContestOpenDateTime');
				$ContestCloseDateTime = $this->input->post('ContestCloseDateTime');
				$ContestVisibleToAll = $this->input->post('ContestVisibleToAll');
                
                $contestInfo = array();
                
                $contestInfo = array('ContestName'=>$ContestName,
								     'ContestPrizePool'=>$ContestPrizePool,
									 'ContestEntryFees'=>$ContestEntryFees,
									 'Zero2CroreMargin'=>$Zero2CroreMargin,
								     'ContestSpotsTotal'=>$ContestSpotsTotal,
									 'ContestDate'=>$ContestDate,
									 'PSMCDT'=>$PSMCDT,
								     'ContestAllowMultipleTeams'=>$ContestAllowMultipleTeams,
									 'ContestMaximumTeamAllowed'=>$ContestMaximumTeamAllowed,
								     'ContestFinalPrizePool'=>$ContestFinalPrizePool,
									 'ContestOpenDateTime'=>$ContestOpenDateTime,
								     'ContestCloseDateTime'=>$ContestCloseDateTime,
									 'ContestVisibleToAll'=>$ContestVisibleToAll,
									 'updatedBy'=>$this->vendorId, 
									 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $result = $this->contest_model->editContest($contestInfo, $contestId, $zone_arr, $company_arr, $company_points_arr, $lower_bound_rank_arr, $upper_bound_rank_arr, $prize_money_arr);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Contest updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Contest updation failed');
                }
                
                redirect('contestListing');
            }
        }
    }
	
	/**
     * This function is used to check whether contest already exist or not
     */
    function checkContestExists()
    {
        $contestId = $this->input->post("ID");
        $ContestCode = $this->input->post("ContestCode");

        if(empty($contestId)){
            $result = $this->contest_model->checkContestExists($ContestCode);
        } else {
            $result = $this->contest_model->checkContestExists($ContestCode, $contestId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>