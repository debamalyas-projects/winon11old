<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class VendorProduct  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('vendorProduct_model');
		$this->load->model('product_model');
		$this->load->model('vendor_model');
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
    function vendorProductListing($product_id,$offset)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('vendorProduct_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->vendorProduct_model->vendorProductListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "vendorProductListing/".$product_id."/", $count, 5, 3);
            
            $data['vendorProductRecords'] = $this->vendorProduct_model->vendorProductListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Vendor Product Listing';
            
            $this->loadViews("vendorProduct", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewVendorProduct($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('vendorProduct_model');
			$this->load->model('vendor_model');
			
			$data=array();
			
			$data['vendorRecords'] = $this->vendor_model->getAllVendor();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Vendor Product';

            $this->loadViews("addNewVendorProduct", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postVendorProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('vendor_id','Vendor','trim|required|xss_clean');
			$this->form_validation->set_rules('stock','Stock','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('discount','Discount','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('price','Price','trim|required|numeric|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewVendorProduct();
            }
            else
            {
                $vendor_id = $this->input->post('vendor_id');
				$stock = $this->input->post('stock');
				$discount = $this->input->post('discount');
				$price = $this->input->post('price');
				$product_id = $this->input->post('product_id');
				
                
                $vendorProductInfo = array(
									 'vendor_id'=>$vendor_id,
									 'stock'=>$stock,
									 'discount'=>$discount,
									 'price'=>$price,
									 'product_id'=>$product_id,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('vendorProduct_model');
                $result = $this->vendorProduct_model->addNewVendorProduct($vendorProductInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New vendor product created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vendor product creation failed');
                }
                
                redirect('addNewVendorProduct/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusVendorProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$vendorProduct_arr = $this->vendorProduct_model->getVendorProductInfo($id);
			
			$status = $vendorProduct_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $vendorProductInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->vendorProduct_model->changeStatusVendorProduct($id, $vendorProductInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editVendorProductOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('vendor_model');
			
			$data=array();
			
			$data['vendorRecords'] = $this->vendor_model->getAllVendor();
            
            $data['vendorProductInfo'] = $this->vendorProduct_model->getVendorProductInfo($id);
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Edit Vendor Product';
            
            $this->loadViews("editVendorProductOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewVendorProductOld($product_id = NULL, $id = NULL)
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
            
            $data['vendorProductInfo'] = $this->vendorProduct_model->getVendorProductInfo($id);
			
			$product_id = $data['vendorProductInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['vendorProductInfo'][0]->product_name = $productArray[0]->name;
			
			$vendor_id = $data['vendorProductInfo'][0]->vendor_id;
			$vendorArray = $this->vendor_model->getVendorInfo($vendor_id);
			$data['vendorProductInfo'][0]->vendor_email = $vendorArray[0]->email;
			
			$created_by = $data['vendorProductInfo'][0]->created_by;
			$updated_by = $data['vendorProductInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['vendorProductInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['vendorProductInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
            $this->global['pageTitle'] = 'Ecommerce : View Vendor Product';
            
            $this->loadViews("viewVendorProductOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editVendorProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('vendor_id','Vendor','trim|required|xss_clean');
			$this->form_validation->set_rules('stock','Stock','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('discount','Discount','trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('price','Price','trim|required|numeric|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editVendorProductOld($id);
            }
            else
            {
                $vendor_id = $this->input->post('vendor_id');
				$stock = $this->input->post('stock');
				$discount = $this->input->post('discount');
				$price = $this->input->post('price');
				$product_id = $this->input->post('product_id');
				
                $vendorProductInfo = array(
									 'vendor_id'=>$vendor_id,
									 'stock'=>$stock,
									 'discount'=>$discount,
									 'price'=>$price,
									 'product_id'=>$product_id,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->vendorProduct_model->editVendorProduct($vendorProductInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Vendor product updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vendor product updation failed');
                }
                
                redirect('vendorProductListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkVendorProductExists()
    {
        $vendor_id = $this->input->post("vendor_id");
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->vendorProduct_model->checkVendorProductExists($vendor_id, $product_id);
        } else {
            $result = $this->vendorProduct_model->checkVendorProductExists($vendor_id, $product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>