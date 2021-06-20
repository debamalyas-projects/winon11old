<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Content  extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->load->model('content_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}
	
	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the content list
     */
    function contentListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('content_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->content_model->contentListingCount($searchText);

			$returns = $this->paginationCompress( "content/", $count, 5 );
            
            $data['contentRecords'] = $this->content_model->contentListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Content Listing';
            
            $this->loadViews("content", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to chaange status of the content using content Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusContent()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$content_arr = $this->content_model->getContentInfo($id);
			
			$status = $content_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $contentInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->content_model->changeStatusContent($id, $contentInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewContent()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('content_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Content ';
			$data=array();

            $this->loadViews("addNewContent", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new content to the system
     */
    function postContent()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('tag','Content tag','trim|required|xss_clean');
					
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewContent();
            }
            else
            {
                $tag = $this->input->post('tag');
				$content = $this->input->post('content');
				$contentInfo = array('tag'=>$tag,
								 'content' => $content,
								 'created_by'=>$this->vendorId,
								 'updated_by'=>$this->vendorId, 
								 'created_on'=>date('Y-m-d H:i:s'), 
								 'updated_on'=>date('Y-m-d H:i:s'));
				
				$this->load->model('content_model');
				$result = $this->content_model->addNewContent($contentInfo);
				
				if($result > 0)
				{
					$this->session->set_flashdata('success', 'New content created successfully');
				}
				else
				{
					$this->session->set_flashdata('error', 'Content creation failed');
				}
				redirect('addNewContent');
				
            }
        }
    }
	
	/**
     * This function is used to check whether content already exist or not
     */
    function checkContentExists()
    {
        $id = $this->input->post("id");
        $tag = $this->input->post("tag");

        if(empty($id)){
            $result = $this->content_model->checkContentExists($tag);
        } else {
            $result = $this->content_model->checkContentExists($tag, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
	/**
     * This function is used load content edit information
     * @param number $id : Optional : This is content id
     */
    function editContentOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('contentListing');
            }
            
            $data['contentInfo'] = $this->content_model->getContentInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit content';
            
            $this->loadViews("editContentOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to edit the content information
     */
    function editContent()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
            $this->form_validation->set_rules('tag','Content tag','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editContentOld($id);
            }
            else
            {
                $tag = $this->input->post('tag');
				$content = $this->input->post('content');
				$contentInfo = array('tag'=>$tag,
									 'content' => $content,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s'));
					
				$this->load->model('content_model');
				$result = $this->content_model->editContent($contentInfo, $id);
				
				if($result > 0)
				{
					$this->session->set_flashdata('success', 'Content updated successfully');
					
				}
				else
				{
					$this->session->set_flashdata('error', 'Content updation failed');
				}
				redirect('contentListing');
            }
        }
    }
	
	/**
     * This function is used load content view information
     * @param number $id : Optional : This is content id
     */
    function viewContentOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('contentListing');
            }
            
            $data['contentInfo'] = $this->content_model->getContentInfo($id);
			
			$created_by = $data['contentInfo'][0]->created_by;
			$updated_by = $data['contentInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['contentInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['contentInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Content';
            
            $this->loadViews("viewContentOld", $this->global, $data, NULL);
        }
    }
}