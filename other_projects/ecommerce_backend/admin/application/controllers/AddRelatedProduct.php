<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class AddRelatedProduct  extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('addRelatedProduct_model');
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
    function addRelatedProductListing($product_id,$offset)
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('addRelatedProduct_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->addRelatedProduct_model->addRelatedProductListingCount($searchText,$product_id);

			$returns = $this->paginationCompress( "addRelatedProductListing/".$product_id."/", $count, 5, 3);
            
            $data['addRelatedProductRecords'] = $this->addRelatedProduct_model->addRelatedProductListing($searchText, $returns["page"], $returns["segment"],$product_id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Product Related Cetagory Listing';
          
            $this->loadViews("addRelatedProduct", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewAddRelatedProduct($product_id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('addRelatedProduct_model');
			$this->load->model('product_model');
			
			$data=array();
			
			$data['product_id'] = $product_id;
			
			$data['brandRecords'] = $this->addRelatedProduct_model->getAllProduct($data['product_id']);
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Related Product Information';
			
			$data['productRecord'] = $this->addRelatedProduct_model->getProductInfo($data['product_id']);;
			
            $this->loadViews("addNewAddRelatedProduct", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new vendor product to the system
     */
    function postAddRelatedProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product_id','required');
			$this->form_validation->set_rules('related_product_id','Related_product_id','required');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewAddRelatedProduct();
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$related_product_id = $this->input->post('related_product_id');
				
				$addRelatedProductInfo = array(
									 'product_id'=>$product_id,
									 'related_product_id'=>$related_product_id,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $this->load->model('addRelatedProduct_model');
                $result = $this->addRelatedProduct_model->addNewAddRelatedProduct($addRelatedProductInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New product related category created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Product related category creation failed');
                }
                
                redirect('addNewAddRelatedProduct/'.$product_id);
            }
        }
    }
	
	/**
     * This function is used to chaange status of the Vendor Product using vendor product Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusAddRelatedProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$addRelatedProduct_arr = $this->addRelatedProduct_model->getAddRelatedProductInfo($id);
			
			$status = $addRelatedProduct_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $addRelatedProductInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->addRelatedProduct_model->changeStatusAddRelatedProduct($id, $addRelatedProductInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used load vendor product edit information
     * @param number $id : Optional : This is vendor product id
     */
    function editAddRelatedProductOld($product_id = NULL, $id = NULL)
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
            $data['brandRecords'] = $this->addRelatedProduct_model->getAllProduct($id);
            $data['addRelatedProductInfo'] = $this->addRelatedProduct_model->getViewDetails($id);
			
			$data['product_id'] = $product_id;
			
            $this->global['pageTitle'] = 'Ecommerce : Edit Product Related Category';
            
            $this->loadViews("editAddRelatedProductOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used load vendor product view information
     * @param number $id : Optional : This is vendor product id
     */
    function viewAddRelatedProductOld($product_id = NULL, $id = NULL)
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
            
            $data['addRelatedProductInfo'] = $this->addRelatedProduct_model->getViewDetails($id);
			$data['addRelatedProductName'] = $this->addRelatedProduct_model->getRelatedProductViewDetails($id);
			
			$product_id = $data['addRelatedProductInfo'][0]->product_id;
			$productArray = $this->product_model->getProductInfo($product_id);
			$data['addRelatedProductInfo'][0]->product_name = $productArray[0]->name;
			
			$created_by = $data['addRelatedProductInfo'][0]->created_by;
			$updated_by = $data['addRelatedProductInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['addRelatedProductInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['addRelatedProductInfo'][0]->updated_by = $updated_byUserArray[0]->email;
			
			$data['product_id'] = $product_id; 
            
			
            $this->global['pageTitle'] = 'Ecommerce : View Product Related Category';
            
            $this->loadViews("viewAddRelatedProductOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the vendor product information
     */
    function editAddRelatedProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
			$this->form_validation->set_rules('related_product_id','Related_product_id','trim|required|xss_clean');
			$this->form_validation->set_rules('product_id','Product_id','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editAddRelatedProductOld($id);
            }
            else
            {
                $product_id = $this->input->post('product_id');
				$related_product_id = $this->input->post('related_product_id');
				
                $addRelatedProductInfo = array(
									 'product_id'=>$product_id,
									 'related_product_id'=>$related_product_id,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s')
									 );
                
                $result = $this->addRelatedProduct_model->editAddRelatedProduct($addRelatedProductInfo, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Related product updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Related product updation failed');
                }
                
                redirect('addRelatedProductListing/'.$product_id.'/0');
            }
        }
    }
	
	/**
     * This function is used to check whether vendor product already exist or not
     */
    function checkAddRelatedProductExists()
    {
        
        $product_id = $this->input->post("product_id");
		$id = $this->input->post("id");

        if(empty($id)){
            $result = $this->addRelatedProduct_model->checkAddRelatedProductExists($product_id);
        } else {
            $result = $this->addRelatedProduct_model->checkAddRelatedProductExists($product_id, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
}
?>