<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MoneyClaim extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('moneyClaim_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the moneyClaim list
     */
    function moneyClaimListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('moneyClaim_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->moneyClaim_model->moneyClaimListingCount($searchText);

			$returns = $this->paginationCompress( "moneyClaim/", $count, 5 );
            
            $data['moneyClaimRecords'] = $this->moneyClaim_model->moneyClaimListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : MoneyClaim Listing';
            
            $this->loadViews("moneyClaim", $this->global, $data, NULL);
        }
    }
}
	
?>