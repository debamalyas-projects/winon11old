<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductRelatedCategory  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productRelatedCategory_model');
		$this->load->model('product_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}

	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the vendor product list
     */
    function productRelatedCategoryListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedCategory_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->productRelatedCategory_model->productRelatedCategoryListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "productRelatedCategoryListing/".$product_id."/", $count, 5, 3);
            
            $data['productRelatedCategoryRecords'] = $this->productRelatedCategory_model->productRelatedCategoryListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Cetagory Listing';
          
            $this->loadViews("productRelatedCategory", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductRelatedCategory($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedCategory_model');
			$this->load->model('product_model');
			$this->load->model('category_model');
			
			$data=array();
			
			$data['brandRecords'] = $this->category_model->getAllBrand();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Related Cetagory Information';
			
			$data['productRecord'] = $this->productRelatedCategory_model->getProductInfo($data['product_id']);;
			
            $this->loadViews("addNewProductRelatedCategory", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductRelatedCategory()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','required');
			$this->form_validation->set_rules('category_id','Category_id','required');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductRelatedCategory();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$category_id = $this->input->post('category_id');
				
				$productRelatedCategoryInfo = array(
									 'product_id'=>$product_id,
									 'category_id'=>$category_id,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productRelatedCategory_model');
                $result = $this->productRelatedCategory_model->addNewProductRelatedCategory($productRelatedCategoryInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related category created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related category creation failed');
                }
                
                redirect('addNewProductRelatedCategory/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductRelatedCategory()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productRelatedCategory_arr = $this->productRelatedCategory_model->getProductRelatedCategoryInfo($id);
			
			$status = $productRelatedCategory_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productRelatedCategoryInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productRelatedCategory_model->changeStatusProductRelatedCategory($id, $productRelatedCategoryInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductRelatedCategoryOld($product_id = NULL, $id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('dashboard');
            }
			
			if($product_id == null)
            {
                redirect('dashboard');
            }
			
			$this->load->model('category_model');
			
			$data=array();
            $data['brandRecords'] = $this->category_model->getAllBrand();
            $data['productRelatedCategoryInfo'] = $this->productRelatedCategory_model->getViewDetails($id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Category';
            
            $this->loadViews("editProductRelatedCategoryOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductRelatedCategoryOld($product_id = NULL, $id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			
            if($id == null)
            {
                redirect('dashboard');
            }
			
			if($product_id == null)
            {
                redirect('dashboard');
            }
            
            $data['productRelatedCategoryInfo'] = $this->productRelatedCategory_model->getViewDetails($id);
			
			$product_id = $data['productRelatedCategoryInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productRelatedCategoryInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productRelatedCategoryInfo'][0]->created_by;
			$updated_by = $data['productRelatedCategoryInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productRelatedCategoryInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productRelatedCategoryInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Category';
            
            $this->loadViews("viewProductRelatedCategoryOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductRelatedCategory()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('category_id','Category_id','trim|required|xss_clean');
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProductRelatedCategoryOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$category_id = $this->input->post('category_id');
				
                $productRelatedCategoryInfo = array(
									 'product_id'=>$product_id,
									 'category_id'=>$category_id,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productRelatedCategory_model->editProductRelatedCategory($productRelatedCategoryInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related category updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related category updation failed');
                }
                
                redirect('productRelatedCategoryListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductRelatedCategoryExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productRelatedCategory_model->checkProductRelatedCategoryExists($product_id);
        } else {
            $result = $this->productRelatedCategory_model->checkProductRelatedCategoryExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>