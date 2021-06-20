<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Faq extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('faq_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the faq list
     */
    function faqListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('faq_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->faq_model->faqListingCount($searchText);

			$returns = $this->paginationCompress( "faqListing/", $count, 5 );
            
            $data['faqRecords'] = $this->faq_model->faqListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Faq Listing';
            
            $this->loadViews("faq", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewFaq()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('faq_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Faq';
			$data=array();

            $this->loadViews("addNewFaq", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new Faq to the system
     */
    function postFaq()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('question','Question','trim|required|xss_clean');
            $this->form_validation->set_rules('answer','Answer','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewFaq();
            }
            else
            {
                $question = $this->input->post('question');
				$answer = $this->input->post('answer');
                
                $faqInfo = array('question'=>$question,
								 'answer'=>$answer, 
								 'created_by'=>$this->vendorId,
								 'updated_by'=>$this->vendorId, 
								 'created_on'=>date('Y-m-d H:i:s'), 
								 'updated_on'=>date('Y-m-d H:i:s'));
                
                $this->load->model('faq_model');
                $result = $this->faq_model->addNewFaq($faqInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New faq created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Faq creation failed');
                }
                
                redirect('addNewFaq');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the faq using faqId
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusFaq()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$faq_arr = $this->faq_model->getFaqInfo($id);
			//print_r(faq_arr);die();
			$status = $faq_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $faqInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->faq_model->changeStatusFaq($id, $faqInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load faq edit information
     * @param number $faqId : Optional : This is faq id
     */
    function editFaqOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('faqListing');
            }
            
            $data['faqInfo'] = $this->faq_model->getFaqInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit Faq';
            
            $this->loadViews("editFaqOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load faq view information
     * @param number $faqId : Optional : This is faq id
     */
    function viewFaqOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('faqListing');
            }
            
            $data['faqInfo'] = $this->faq_model->getFaqInfo($id);
			
			$created_by = $data['faqInfo'][0]->created_by;
			$updated_by = $data['faqInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['faqInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['faqInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Faq';
            
            $this->loadViews("viewFaqOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the faq information
     */
    function editFaq()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
            $this->form_validation->set_rules('question','Question','trim|required|xss_clean');
            $this->form_validation->set_rules('answer','Answer','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editFaqOld($id);
            }
            else
            {
                $question = $this->input->post('question');
				$answer = $this->input->post('answer');
                
                $faqInfo = array();
                
                $faqInfo = array('question'=>$question,
								 'answer'=>$answer,
								 'updated_by'=>$this->vendorId,  
								 'updated_on'=>date('Y-m-d H:i:s'));
                
                $result = $this->faq_model->editFaq($faqInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Faq updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Faq updation failed');
                }
                
                redirect('faqListing');
            }
        }
    }
	
	/**
     * This function is used to check whether faq already exist or not
     */
    function checkFaqExists()
    {
        $id = $this->input->post("id");
        $question = $this->input->post("question");

        if(empty($id)){
            $result = $this->faq_model->checkFaqExists($question);
        } else {
            $result = $this->faq_model->checkFaqExists($question, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>