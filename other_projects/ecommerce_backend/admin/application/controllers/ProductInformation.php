<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ProductInformation  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('productInformation_model');
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
    function productInformationListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productInformation_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
           
            $this->load->library('pagination');
            
            $count = $this->productInformation_model->productInformationListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "productInformationListing/".$product_id."/", $count, 5, 3);
            
            $data['productInformationRecords'] = $this->productInformation_model->productInformationListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
           
            $this->global['pageTitle'] = 'Ecommerce : Vendor Product Listing';
          
            $this->loadViews("productInformation", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewProductInformation($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('productInformation_model');
			$this->load->model('product_model');
			
			$data=array();
			
			$data['productRecords'] = $this->product_model->getAllProduct();
			
			$data['product_id'] = $product_id;
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Product Information';

            $this->loadViews("addNewProductInformation", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postProductInformation()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('product_id','Pendor','trim|required|xss_clean');
			$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewProductInformation();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$title = $this->input->post('title');
				$description = $this->input->post('description');
				
				$productInformationInfo = array(
									 'product_id'=>$product_id,
									 'title'=>$title,
									 'description'=>$description,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('productInformation_model');
                $result = $this->productInformation_model->addNewProductInformation($productInformationInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product information created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product information creation failed');
                }
                
                redirect('addNewProductInformation/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductInformation()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$productInformation_arr = $this->productInformation_model->getProductInformationInfo($id);
			
			$status = $productInformation_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $productInformationInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->productInformation_model->changeStatusProductInformation($id, $productInformationInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editProductInformationOld($product_id = NULL, $id = NULL)
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
			
			$this->load->model('product_model');
			
			$data=array();
			
			$data['productRecords'] = $this->product_model->getAllProduct();
            
            $data['productInformationInfo'] = $this->productInformation_model->getProductInformationInfo($id);
			
			$data['product_id'] = $product_id;
            
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Information';
            
            $this->loadViews("editProductInformationOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewProductInformationOld($product_id = NULL, $id = NULL)
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
            
            $data['productInformationInfo'] = $this->productInformation_model->getProductInformationInfo($id);
			
			$product_id = $data['productInformationInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['productInformationInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['productInformationInfo'][0]->created_by;
			$updated_by = $data['productInformationInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['productInformationInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['productInformationInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Information';
            
            $this->loadViews("viewProductInformationOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editProductInformation()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('product_id','Pendor','trim|required|xss_clean');
			$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editProductInformationOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$title = $this->input->post('title');
				$description = $this->input->post('description');
				
                $productInformationInfo = array(
									 'product_id'=>$product_id,
									 'title'=>$title,
									 'description'=>$description,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->productInformation_model->editProductInformation($productInformationInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Product information updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product information updation failed');
                }
                
                redirect('productInformationListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkProductInformationExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->productInformation_model->checkProductInformationExists($product_id);
        } else {
            $result = $this->productInformation_model->checkProductInformationExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>