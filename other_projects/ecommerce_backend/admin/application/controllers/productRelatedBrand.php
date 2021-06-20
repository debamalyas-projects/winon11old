<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductRelatedBrand  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productRelatedBrand_model');
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
    function productRelatedBrandListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedBrand_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->productRelatedBrand_model->productRelatedBrandListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "productRelatedBrandListing/".$product_id."/", $count, 5, 3);
            
            $data['productRelatedBrandRecords'] = $this->productRelatedBrand_model->productRelatedBrandListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Brand Listing';
          
            $this->loadViews("productRelatedBrand", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductRelatedBrand($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedBrand_model');
			$this->load->model('product_model');
			$this->load->model('brand_model');
			
			$data=array();
			
			$data['brandRecords'] = $this->brand_model->getAllBrand();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Related Brand Information';
			
			$data['productRecord'] = $this->productRelatedBrand_model->getProductInfo($data['product_id']);;
			
            $this->loadViews("addNewProductRelatedBrand", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductRelatedBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			$this->form_validation->set_rules('brand_id','Brand_id','trim|required|xss_clean');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductRelatedBrand();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$brand_id = $this->input->post('brand_id');
				
				$productRelatedBrandInfo = array(
									 'product_id'=>$product_id,
									 'brand_id'=>$brand_id,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productRelatedBrand_model');
                $result = $this->productRelatedBrand_model->addNewProductRelatedBrand($productRelatedBrandInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related brand created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related brand creation failed');
                }
                
                redirect('addNewProductRelatedBrand/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductRelatedBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productRelatedBrand_arr = $this->productRelatedBrand_model->getProductRelatedBrandInfo($id);
			
			$status = $productRelatedBrand_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productRelatedBrandInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productRelatedBrand_model->changeStatusProductRelatedBrand($id, $productRelatedBrandInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductRelatedBrandOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('brand_model');
			
			$data=array();
            $data['brandRecords'] = $this->brand_model->getAllBrand();
            $data['productRelatedBrandInfo'] = $this->productRelatedBrand_model->getViewDetails($id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Brand';
            
            $this->loadViews("editProductRelatedBrandOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductRelatedBrandOld($product_id = NULL, $id = NULL)
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
            
            $data['productRelatedBrandInfo'] = $this->productRelatedBrand_model->getViewDetails($id);
			
			$product_id = $data['productRelatedBrandInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productRelatedBrandInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productRelatedBrandInfo'][0]->created_by;
			$updated_by = $data['productRelatedBrandInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productRelatedBrandInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productRelatedBrandInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Brand';
            
            $this->loadViews("viewProductRelatedBrandOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductRelatedBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('brand_id','Brand_id','trim|required|xss_clean');
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProductRelatedBrandOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$brand_id = $this->input->post('brand_id');
				
                $productRelatedBrandInfo = array(
									 'product_id'=>$product_id,
									 'brand_id'=>$brand_id,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productRelatedBrand_model->editProductRelatedBrand($productRelatedBrandInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related brand updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related brand updation failed');
                }
                
                redirect('productRelatedBrandListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductRelatedBrandExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productRelatedBrand_model->checkProductRelatedBrandExists($product_id);
        } else {
            $result = $this->productRelatedBrand_model->checkProductRelatedBrandExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>