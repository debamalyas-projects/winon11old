<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductVendorUnit  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productVendorUnit_model');
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
    function productVendorUnitListing($vendor_id,$product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productVendorUnit_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->productVendorUnit_model->productVendorUnitListingCount($searchText,$vendor_id,$product_id);

			$returns = $this->paginationCompress( "productVendorUnitListing/".$vendor_id.'/'.$product_id."/", $count, 5, 4);
            
            $data['productVendorUnitRecords'] = $this->productVendorUnit_model->productVendorUnitListing($searchText, $returns["page"], $returns["segment"],$vendor_id,$product_id);
			
			
			$data['product_id'] = $product_id;
			$data['vendor_id'] = $vendor_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Vendor Unit Listing';
          
            $this->loadViews("productVendorUnit", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductVendorUnit($vendor_id,$product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productVendorUnit_model');
			$this->load->model('product_model');
			$this->load->model('vendor_model');
			$this->load->model('unit_model');
			
			$data=array();
			
			$data['brandRecords'] = $this->unit_model->getAllUnit();
			
			$data['product_id'] = $product_id;
			$data['vendor_id'] = $vendor_id;
          
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Unit Information';
			
			$data['vendorProductRecord'] = $this->productVendorUnit_model->getVendorProductInfo($data['product_id']);
			$data['productRecord'] = $this->productVendorUnit_model->getProductInfo($data['product_id']);
		
			$data['vendorRecord'] = $this->productVendorUnit_model->getVendorInfo($data['vendor_id']);
			$data['unitRecord'] = $this->productVendorUnit_model->getUnitInfo($data['productRecord'][0]->unit);
			
            $this->loadViews("addNewProductVendorUnit", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductVendorUnit()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','required');
			$this->form_validation->set_rules('vendor_id','Vendor_id','required');
			$this->form_validation->set_rules('unit_id','Unit_id','required');
			$this->form_validation->set_rules('per_unit_price','Per_unit_price','trim|required|xss_clean');
			$this->form_validation->set_rules('quantity','Quantity','required');
			$this->form_validation->set_rules('stock','Stock','required');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductVendorUnit();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$vendor_id = $this->input->post('vendor_id');
				$unit_id = $this->input->post('unit_id');
				$per_unit_price = $this->input->post('per_unit_price');
				$quantity = $this->input->post('quantity');
				$stock = $this->input->post('stock');
				
				$productVendorUnitInfo = array(
									 'product_id'=>$product_id,
									 'vendor_id'=>$vendor_id,
									 'unit_id'=>$unit_id,
									 'per_unit_price'=>$per_unit_price,
									 'quantity'=>$quantity,
									 'stock'=>$stock,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productVendorUnit_model');
                $result = $this->productVendorUnit_model->addNewProductVendorUnit($productVendorUnitInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product unit created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product unit creation failed');
                }
                
                redirect('addNewProductVendorUnit/'.$vendor_id.'/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductVendorUnit()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productVendorUnit_arr = $this->productVendorUnit_model->getProductVendorUnitInfo($id);
			
			$status = $productVendorUnit_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productVendorUnitInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productVendorUnit_model->changeStatusProductVendorUnit($id, $productVendorUnitInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductVendorUnitOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('unit_model');
			
			$data=array();
            $data['brandRecords'] = $this->unit_model->getAllUnit();
			
            $data['productVendorUnitInfo'] = $this->productVendorUnit_model->getViewDetails($id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Category';
            
            $this->loadViews("editProductVendorUnitOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductVendorUnitOld($product_id = NULL, $id = NULL)
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
            
            $data['productVendorUnitInfo'] = $this->productVendorUnit_model->getViewDetails($id);
			
			$product_id = $data['productVendorUnitInfo'][0]->product_id;
			$vendor_id = $data['productVendorUnitInfo'][0]->vendor_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productVendorUnitInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productVendorUnitInfo'][0]->created_by;
			$updated_by = $data['productVendorUnitInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productVendorUnitInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productVendorUnitInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
			$data['vendor_id'] = $vendor_id;
           
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Units';
            
            $this->loadViews("viewProductVendorUnitOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductVendorUnit()
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
          
			$this->form_validation->set_rules('vendor_id','Vendor_id','trim|required|xss_clean');
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			$this->form_validation->set_rules('unit_id','Unit_id','trim|required|xss_clean');
			$this->form_validation->set_rules('per_unit_price','Per_unit_price','trim|required|xss_clean');
			$this->form_validation->set_rules('quantity','Quantity','trim|required|xss_clean');
			$this->form_validation->set_rules('stock','Stock','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
				
                $this->editProductVendorUnitOld($id);
            }
            else
            {
				
                $product_id = $this->input->post('product_id');
				$vendor_id = $this->input->post('vendor_id');
				$unit_id = $this->input->post('unit_id');
				$per_unit_price = $this->input->post('per_unit_price');
				$quantity = $this->input->post('quantity');
				$stock = $this->input->post('stock');
				
                $productVendorUnitInfo = array(
									 'product_id'=>$product_id,
									 'vendor_id'=>$vendor_id,
									 'unit_id'=>$unit_id,
									 'per_unit_price'=>$per_unit_price,
									 'quantity'=>$quantity,
									 'stock'=>$stock,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productVendorUnit_model->editProductVendorUnit($productVendorUnitInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product related unit updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related unit updation failed');
                }
                
                redirect('productVendorUnitListing/'.$vendor_id.'/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductVendorUnitExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productVendorUnit_model->checkProductVendorUnitExists($product_id);
        } else {
            $result = $this->productVendorUnit_model->checkProductVendorUnitExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>