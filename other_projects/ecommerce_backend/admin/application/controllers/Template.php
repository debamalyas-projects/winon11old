<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Template  extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->load->model('template_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}
	
	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the template list
     */
    function templateListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('template_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->template_model->templateListingCount($searchText);

			$returns = $this->paginationCompress( "template/", $count, 5 );
            
            $data['templateRecords'] = $this->template_model->templateListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Template Listing';
            
            $this->loadViews("template", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to chaange status of the template using template Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusTemplate()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$template_arr = $this->template_model->getTemplateInfo($id);
			
			$status = $template_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $templateInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->template_model->changeStatusTemplate($id, $templateInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewTemplate()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('template_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Template ';
			$data=array();

            $this->loadViews("addNewTemplate", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new template to the system
     */
    function postTemplate()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Template name','trim|required|xss_clean');
					
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewTemplate();
            }
            else
            {
                $name = $this->input->post('name');
				$html = $this->input->post('html');
				$templateInfo = array('name'=>$name,
								 'html' => $html,
								 'created_by'=>$this->vendorId,
								 'updated_by'=>$this->vendorId, 
								 'created_on'=>date('Y-m-d H:i:s'), 
								 'updated_on'=>date('Y-m-d H:i:s'));
				
				$this->load->model('template_model');
				$result = $this->template_model->addNewTemplate($templateInfo);
				
				if($result > 0)
				{
					$this->session->set_flashdata('success', 'New template created successfully');
				}
				else
				{
					$this->session->set_flashdata('error', 'Template creation failed');
				}
				redirect('addNewTemplate');
				
            }
        }
    }
	
	/**
     * This function is used to check whether template already exist or not
     */
    function checkTemplateExists()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");

        if(empty($id)){
            $result = $this->template_model->checkTemplateExists($name);
        } else {
            $result = $this->template_model->checkTemplateExists($name, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
	/**
     * This function is used load template edit information
     * @param number $id : Optional : This is template id
     */
    function editTemplateOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('templateListing');
            }
            
            $data['templateInfo'] = $this->template_model->getTemplateInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit template';
            
            $this->loadViews("editTemplateOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to edit the template information
     */
    function editTemplate()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
            $this->form_validation->set_rules('name','Template name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editTemplateOld($id);
            }
            else
            {
                $name = $this->input->post('name');
				$html = $this->input->post('html');
				$templateInfo = array('name'=>$name,
									 'html' => $html,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s'));
					
				$this->load->model('template_model');
				$result = $this->template_model->editTemplate($templateInfo, $id);
				
				if($result > 0)
				{
					$this->session->set_flashdata('success', 'Template updated successfully');
					
				}
				else
				{
					$this->session->set_flashdata('error', 'Template updation failed');
				}
				redirect('templateListing');
            }
        }
    }
	
	/**
     * This function is used load template view information
     * @param number $id : Optional : This is template id
     */
    function viewTemplateOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('templateListing');
            }
            
            $data['templateInfo'] = $this->template_model->getTemplateInfo($id);
			
			$created_by = $data['templateInfo'][0]->created_by;
			$updated_by = $data['templateInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['templateInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['templateInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Template';
            
            $this->loadViews("viewTemplateOld", $this->global, $data, NULL);
        }
    }
}