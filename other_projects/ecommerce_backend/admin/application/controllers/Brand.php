<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Brand  extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->load->model('brand_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}
	
	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the brand list
     */
    function brandListing()
    {
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('brand_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->brand_model->brandListingCount($searchText);

			$returns = $this->paginationCompress( "brandListing/", $count, 5 );
            
            $data['brandRecords'] = $this->brand_model->brandListing($searchText, $returns["page"], $returns["segment"]);
			
            $this->global['pageTitle'] = 'Ecommerce : Brand Listing';
            
            $this->loadViews("brand", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to chaange status of the brand using brand Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$brand_arr = $this->brand_model->getBrandInfo($id);
			
			$status = $brand_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $brandInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->brand_model->changeStatusBrand($id, $brandInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('brand_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Brand ';
			$data=array();

            $this->loadViews("addNewBrand", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new brand to the system
     */
    function postBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Brand name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewBrand();
            }
            else
            {
				$name = $this->input->post('name');
				$allowed = array('png', 'jpg','jpeg');
				$filename = $_FILES['image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if($_FILES['image']['tmp_name']==''){
					$this->session->set_flashdata('error', 'Please upload any file.');
					$this->addNewBrand();
				}else if(!in_array($ext, $allowed)){
					$this->session->set_flashdata('error', 'Please upload .jpg or .jpeg or .png file.');
					$this->addNewBrand();
				}
				else{
				
					$file = $_FILES['image']['tmp_name'];
					$file_name = time().'_'.$_FILES['image']['name'];
					copy($file,'uploads/'.$file_name);
					
					$image = base_url().'uploads/'.$file_name;
					
					
					$brandInfo = array('name'=>$name,
									 'image' => $image,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
					
					$this->load->model('brand_model');
					$result = $this->brand_model->addNewBrand($brandInfo);
					
					if($result > 0)
					{
						$this->session->set_flashdata('success', 'New brand created successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Brand creation failed');
					}
					
					redirect('addNewBrand');
				}
            }
        }
    }
	
	/**
     * This function is used to check whether brand already exist or not
     */
    function checkBrandExists()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");

        if(empty($id)){
            $result = $this->brand_model->checkBrandExists($name);
        } else {
            $result = $this->brand_model->checkBrandExists($name, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
	/**
     * This function is used load brand edit information
     * @param number $id : Optional : This is brand id
     */
    function editBrandOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('brandListing');
            }
            
            $data['brandInfo'] = $this->brand_model->getBrandInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit brand';
            
            $this->loadViews("editBrandOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to edit the brand information
     */
    function editBrand()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
            $this->form_validation->set_rules('name','Brand name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editBrandOld($id);
            }
            else
            {
				
				$name = $this->input->post('name');
				$allowed = array('png', 'jpg','jpeg');
				$filename = $_FILES['image']['name'];
				
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if($_FILES['image']['tmp_name']==''){
					$this->session->set_flashdata('error', 'Please upload any file.');
					$this->addNewBrand();
				}else if(!in_array($ext, $allowed)){
					$this->session->set_flashdata('error', 'Please upload .jpg or .jpeg or .png file.');
					$this->addNewBrand();
				}else{
				
					$file = $_FILES['image']['tmp_name'];
					$file_name = time().'_'.$_FILES['image']['name'];
					copy($file,'uploads/'.$file_name);
					
					$image = base_url().'uploads/'.$file_name;
				
					$brandInfo = array('name'=>$name,
										 'image' => $image,
										 'updated_by'=>$this->vendorId,
										 'updated_on'=>date('Y-m-d H:i:s'));
						
					$this->load->model('brand_model');
					$result = $this->brand_model->editBrand($brandInfo, $id);
					
					if($result > 0)
					{
						$this->session->set_flashdata('success', 'Brand updated successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Brand updation failed');
					}
					
					redirect('brandListing');
				}
            }
        }
    }
	
	/**
     * This function is used load brand view information
     * @param number $id : Optional : This is brand id
     */
    function viewBrandOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('brandListing');
            }
            
            $data['brandInfo'] = $this->brand_model->getBrandInfo($id);
			
			$created_by = $data['brandInfo'][0]->created_by;
			$updated_by = $data['brandInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['brandInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['brandInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Brand';
            
            $this->loadViews("viewBrandOld", $this->global, $data, NULL);
        }
    }
}