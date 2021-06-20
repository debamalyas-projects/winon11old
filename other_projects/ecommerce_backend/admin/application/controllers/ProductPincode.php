<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductPincode  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productPincode_model');
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
    function productPincodeListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productPincode_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->productPincode_model->productPincodeListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "productPincodeListing/".$product_id."/", $count, 5, 3);
            
            $data['productPincodeRecords'] = $this->productPincode_model->productPincodeListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Pincode Listing';
          
            $this->loadViews("productPincode", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductPincode($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productPincode_model');
			$this->load->model('product_model');
			
			$data=array();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Related Pincode Information';
			
			$data['productRecord'] = $this->productPincode_model->getProductInfo($data['product_id']);;
			
            $this->loadViews("addNewProductPincode", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductPincode()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','required');
			$this->form_validation->set_rules('pincode','Pincode','required');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductPincode();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$pincode = $this->input->post('pincode');
				
				$productPincodeInfo = array(
									 'product_id'=>$product_id,
									 'pincode'=>$pincode,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productPincode_model');
                $result = $this->productPincode_model->addNewProductPincode($productPincodeInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related pincode created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related pincode creation failed');
                }
                
                redirect('addNewProductPincode/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductPincode()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productPincode_arr = $this->productPincode_model->getProductPincodeInfo($id);
			
			$status = $productPincode_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productPincodeInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productPincode_model->changeStatusProductPincode($id, $productPincodeInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductPincodeOld($product_id = NULL, $id = NULL)
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
			
			$data=array();
            $data['productPincodeInfo'] = $this->productPincode_model->getViewDetails($id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Pincode';
            
            $this->loadViews("editProductPincodeOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductPincodeOld($product_id = NULL, $id = NULL)
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
            
            $data['productPincodeInfo'] = $this->productPincode_model->getViewDetails($id);
			
			$product_id = $data['productPincodeInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productPincodeInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productPincodeInfo'][0]->created_by;
			$updated_by = $data['productPincodeInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productPincodeInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productPincodeInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Category';
            
            $this->loadViews("viewProductPincodeOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductPincode()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('pincode','Pincode','required');
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProductPincodeOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$pincode = $this->input->post('pincode');
				
                $productPincodeInfo = array(
									 'product_id'=>$product_id,
									 'pincode'=>$pincode,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productPincode_model->editProductPincode($productPincodeInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related pincode updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related pincode updation failed');
                }
                
                redirect('productPincodeListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductPincodeExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productPincode_model->checkProductPincodeExists($product_id);
        } else {
            $result = $this->productPincode_model->checkProductPincodeExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>