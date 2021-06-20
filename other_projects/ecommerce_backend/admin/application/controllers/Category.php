<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Category extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the category list
     */
    function categoryListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('category_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->category_model->categoryListingCount($searchText);

			$returns = $this->paginationCompress( "category/", $count, 5 );
            
            $data['categoryRecords'] = $this->category_model->categoryListing($searchText, $returns["page"], $returns["segment"]);
			
            $this->global['pageTitle'] = 'Ecommerce : Category Listing';
            
            $this->loadViews("category", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewCategory()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('category_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Category';
			$data=array();

            $this->loadViews("addNewCategory", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new category to the system
     */
    function postCategory()
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
                $this->addNewCategory();
            }
            else
            {
                $name = $this->input->post('name');
				$permalink = strtolower($name);
				$permalink = explode(" ",$permalink);
				$permalink = implode("-",$permalink);
                
                $categoryInfo = array('name'=>$name,
									  'permalink'=>$permalink,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                $this->load->model('category_model');
                $result = $this->category_model->addNewCategory($categoryInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Category created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Category creation failed');
                }
                
                redirect('addNewCategory');
            }
        }
    }
	
	/**
     * This function is used to chaange status of the category using id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCategory()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$category_arr = $this->category_model->getCategoryInfo($categoryid);
			
			$status = $category_arr[0]->Status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $categoryInfo = array('Status'=>$statusVal,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
            
            $result = $this->category_model->changeStatusCategory($id, $categoryInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load category edit information
     * @param number $id : Optional : This is id
     */
    function editCategoryOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			
            if($id == null)
            {
                redirect('categoryListing');
            }
            
            $data['categoryInfo'] = $this->category_model->getCategoryInfo($id);
			
            
            $this->global['pageTitle'] = 'Ecommerce : Edit Category';
            
            $this->loadViews("editCategoryOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load category view information
     * @param number $id : Optional : This is id
     */
    function viewCategoryOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('categoryListing');
            }
            
            $data['categoryInfo'] = $this->category_model->getCategoryInfo($id);
			
			$created_by = $data['categoryInfo'][0]->created_by;
			$updated_by = $data['categoryInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['categoryInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['categoryInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Category';
            
            $this->loadViews("viewCategoryOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the category information
     */
    function editCategory()
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
                $this->editOld($id);
            }
            else
            {
                $name = $this->input->post('name');
			
                
                $categoryInfo = array();
                
                $categoryInfo = array('name'=>$name,
									 
									 'updated_by'=>$this->vendorId,  
									 'updated_on'=>date('Y-m-d H:i:s'));
                
                $result = $this->category_model->editCategory($categoryInfo, $id);
                
				
				
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Category updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Category updation failed');
                }
                
                redirect('categoryListing');
            }
        }
    }
	
	/**
     * This function is used to check whether category already exist or not
     */
    function checkCategoryExists()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");

        if(empty($id)){
            $result = $this->category_model->checkCategoryExists($name);
        } else {
            $result = $this->category_model->checkCategoryExists($name, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>