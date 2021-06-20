<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductRelatedAssetLink  extends BaseController
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
    function productRelatedAssetLinkListing($product_id,$offset)
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
            
            $count = $this->productRelatedAsset_model->productRelatedAssetListingCount($searchText,$product_id,'asset_link');

			$returns = $this->paginationCompress( "productRelatedAssetLinkListing/".$product_id."/", $count, 5, 3);
            
            $data['productRelatedAssetLinkRecords'] = $this->productRelatedAsset_model->productRelatedAssetListing($searchText, $returns["page"], $returns["segment"],$product_id,'asset_link');
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Asset Link Listing';
          
            $this->loadViews("productRelatedAssetLink", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductRelatedAssetLink($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productRelatedAsset_model');
			$this->load->model('product_model');
			$this->load->model('assetLink_model');
			
			$data=array();
			
			$data['brandRecords'] = $this->assetLink_model->getAllBrand();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Related Asset Link Information';
			
			$data['productRecord'] = $this->productRelatedAsset_model->getProductInfo($data['product_id']);;
			
            $this->loadViews("addNewProductRelatedAssetLink", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductRelatedAssetLink()
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
                $this->addNewProductRelatedAssetLink();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$asset_id = $this->input->post('asset_id');
				
				$productRelatedAssetLinkInfo = array(
									 'product_id'=>$product_id,
									 'asset_id'=>$asset_id,
									 'type'=>'asset_link',
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productRelatedAsset_model');
                $result = $this->productRelatedAsset_model->addNewProductRelatedAsset($productRelatedAssetLinkInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related asset created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related asset creation failed');
                }
                
                redirect('addNewProductRelatedAssetLink/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductRelatedAssetLink()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productRelatedAssetLink_arr = $this->productRelatedAsset_model->getProductRelatedAssetLinkInfo($id);
			
			$status = $productRelatedAssetLink_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productRelatedAssetLinkInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productRelatedAsset_model->changeStatusProductRelatedAsset($id, $productRelatedAssetLinkInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductRelatedAssetLinkOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('assetLink_model');
			
			$data=array();
            $data['brandRecords'] = $this->assetLink_model->getAllBrand();
            $data['productRelatedAssetLinkInfo'] = $this->productRelatedAsset_model->getViewDetails($id,'asset_link');
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Asset Link';
            
            $this->loadViews("editProductRelatedAssetLinkOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductRelatedAssetLinkOld($product_id = NULL, $id = NULL)
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
            
            $data['productRelatedAssetLinkInfo'] = $this->productRelatedAsset_model->getViewDetails($id,'asset_link');
		
			$product_id = $data['productRelatedAssetLinkInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productRelatedAssetLinkInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productRelatedAssetLinkInfo'][0]->created_by;
			$updated_by = $data['productRelatedAssetLinkInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productRelatedAssetLinkInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productRelatedAssetLinkInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Asset';
            
            $this->loadViews("viewProductRelatedAssetLinkOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductRelatedAssetLink()
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
                $this->editProductRelatedAssetLinkOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$asset_id = $this->input->post('asset_id');
				
                $productRelatedAssetLinkInfo = array(
									 'product_id'=>$product_id,
									 'asset_id'=>$asset_id,
									 'type'=>'asset_link',
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productRelatedAsset_model->editProductRelatedAsset($productRelatedAssetLinkInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related asset updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related asset updation failed');
                }
                
                redirect('productRelatedAssetLinkListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductRelatedAssetLinkExists()
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