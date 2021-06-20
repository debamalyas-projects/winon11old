<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductRelatedAsset  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productRelatedAsset_model');
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
    function productRelatedAssetListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedAsset_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->productRelatedAsset_model->productRelatedAssetListingCount($searchText,$product_id,'asset');

			$returns = $this->paginationCompress( "productRelatedAssetListing/".$product_id."/", $count, 5, 3);
            
            $data['productRelatedAssetRecords'] = $this->productRelatedAsset_model->productRelatedAssetListing($searchText, $returns["page"], $returns["segment"],$product_id,'asset');
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Asset Listing';
          
            $this->loadViews("productRelatedAsset", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductRelatedAsset($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedAsset_model');
			$this->load->model('product_model');
			$this->load->model('asset_model');
			
			$data=array();
			
			$data['brandRecords'] = $this->asset_model->getAllBrand();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Related Cetagory Information';
			
			$data['productRecord'] = $this->productRelatedAsset_model->getProductInfo($data['product_id']);
			
            $this->loadViews("addNewProductRelatedAsset", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductRelatedAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','required');
			$this->form_validation->set_rules('asset_id','Asset_id','required');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductRelatedAsset();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$asset_id = $this->input->post('asset_id');
				
				$productRelatedAssetInfo = array(
									 'product_id'=>$product_id,
									 'asset_id'=>$asset_id,
									 'type'=>'asset',
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productRelatedAsset_model');
                $result = $this->productRelatedAsset_model->addNewProductRelatedAsset($productRelatedAssetInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related asset created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related asset creation failed');
                }
                
                redirect('addNewProductRelatedAsset/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductRelatedAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productRelatedAsset_arr = $this->productRelatedAsset_model->getProductRelatedAssetInfo($id);
			
			$status = $productRelatedAsset_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productRelatedAssetInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productRelatedAsset_model->changeStatusProductRelatedAsset($id, $productRelatedAssetInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductRelatedAssetOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('asset_model');
			
			$data=array();
            $data['brandRecords'] = $this->asset_model->getAllBrand();
            $data['productRelatedAssetInfo'] = $this->productRelatedAsset_model->getViewDetails($id,'asset');
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Asset';
            
            $this->loadViews("editProductRelatedAssetOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductRelatedAssetOld($product_id = NULL, $id = NULL)
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
            
            $data['productRelatedAssetInfo'] = $this->productRelatedAsset_model->getViewDetails($id,'asset');
			
			$product_id = $data['productRelatedAssetInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productRelatedAssetInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productRelatedAssetInfo'][0]->created_by;
			$updated_by = $data['productRelatedAssetInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productRelatedAssetInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productRelatedAssetInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Asset';
            
            $this->loadViews("viewProductRelatedAssetOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductRelatedAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('asset_id','Asset_id','required');
			$this->form_validation->set_rules('product_id','Product_id','required');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProductRelatedAssetOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$asset_id = $this->input->post('asset_id');
				
                $productRelatedAssetInfo = array(
									 'product_id'=>$product_id,
									 'asset_id'=>$asset_id,
									 'type'=>'asset',
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productRelatedAsset_model->editProductRelatedAsset($productRelatedAssetInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related asset updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related asset updation failed');
                }
                
                redirect('productRelatedAssetListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductRelatedAssetExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productRelatedAsset_model->checkProductRelatedAssetExists($product_id);
        } else {
            $result = $this->productRelatedAsset_model->checkProductRelatedAssetExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>