<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Asset  extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->load->model('asset_model');
		$this->load->model('user_model');
		$this->isLoggedIn();
	}
	
	public function index(){
		$this->global['pageTitle'] = 'Ecommerce : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
	}
	
	/**
     * This function is used to load the asset list
     */
    function assetListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('asset_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->asset_model->assetListingCount($searchText);

			$returns = $this->paginationCompress( "assetListing/", $count, 5 );
            
            $data['assetRecords'] = $this->asset_model->assetListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Ecommerce : Asset Listing';
            
            $this->loadViews("asset", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to chaange status of the asset using asset Id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
			
			$asset_arr = $this->asset_model->getAssetInfo($id);
			
			$status = $asset_arr[0]->status;
			
			if($status=='0'){
				$statusVal='1';
			}else{
				$statusVal='0';
			}
            $assetInfo = array('status'=>$statusVal,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->asset_model->changeStatusAsset($id, $assetInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	/**
     * This function is used to load the add new form
     */
    function addNewAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('asset_model');
            
            $this->global['pageTitle'] = 'Ecommerce : Add New Asset ';
			$data=array();

            $this->loadViews("addNewAsset", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to add new asset to the system
     */
    function postAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Asset name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewAsset();
            }
            else
            {
                $name = $this->input->post('name');
				
				if($_FILES['path']['tmp_name']==''){
					$this->session->set_flashdata('error', 'Please upload any file.');
					$this->addNewAsset();
				}else{
				
					$file = $_FILES['path']['tmp_name'];
					$file_name = time().'_'.$_FILES['path']['name'];
					copy($file,'uploads/'.$file_name);
					
					$path = base_url().'uploads/'.$file_name;
					
					
					$assetInfo = array('name'=>$name,
									 'path' => $path,
									 'created_by'=>$this->vendorId,
									 'updated_by'=>$this->vendorId, 
									 'created_on'=>date('Y-m-d H:i:s'), 
									 'updated_on'=>date('Y-m-d H:i:s'));
					
					$this->load->model('asset_model');
					$result = $this->asset_model->addNewAsset($assetInfo);
					
					if($result > 0)
					{
						$this->session->set_flashdata('success', 'New asset created successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Asset creation failed');
					}
					
					redirect('addNewAsset');
				}
            }
        }
    }
	
	/**
     * This function is used to check whether asset already exist or not
     */
    function checkAssetExists()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");

        if(empty($id)){
            $result = $this->asset_model->checkAssetExists($name);
        } else {
            $result = $this->asset_model->checkAssetExists($name, $id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
	/**
     * This function is used load asset edit information
     * @param number $id : Optional : This is asset id
     */
    function editAssetOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('assetListing');
            }
            
            $data['assetInfo'] = $this->asset_model->getAssetInfo($id);
            
            $this->global['pageTitle'] = 'Ecommerce : Edit asset';
            
            $this->loadViews("editAssetOld", $this->global, $data, NULL);
        }
    }
	
	/**
     * This function is used to edit the asset information
     */
    function editAsset()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
            
            $this->form_validation->set_rules('name','Asset name','trim|required|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editAssetOld($id);
            }
            else
            {
                $name = $this->input->post('name');
				
                if($_FILES['path']['tmp_name']==''){
					$this->load->model('asset_model');
					$result = $this->asset_model->getAssetInfo($id);
					$path = $result[0]->path;
				}else{
				
					$file = $_FILES['path']['tmp_name'];
					$file_name = time().'_'.$_FILES['path']['name'];
					copy($file,'uploads/'.$file_name);
					
					$path = base_url().'uploads/'.$file_name;
				}
				
				$assetInfo = array('name'=>$name,
									 'path' => $path,
									 'updated_by'=>$this->vendorId,
									 'updated_on'=>date('Y-m-d H:i:s'));
					
				$this->load->model('asset_model');
				$result = $this->asset_model->editAsset($assetInfo, $id);
				
				if($result > 0)
				{
					$this->session->set_flashdata('success', 'Asset updated successfully');
				}
				else
				{
					$this->session->set_flashdata('error', 'Asset updation failed');
				}
				
				redirect('assetListing');
            }
        }
    }
	
	/**
     * This function is used load asset view information
     * @param number $id : Optional : This is asset id
     */
    function viewAssetOld($id = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('assetListing');
            }
            
            $data['assetInfo'] = $this->asset_model->getAssetInfo($id);
			
			$created_by = $data['assetInfo'][0]->created_by;
			$updated_by = $data['assetInfo'][0]->updated_by;
			
			$created_byUserArray = $this->user_model->getUserInfo($created_by);
			
			$data['assetInfo'][0]->created_by = $created_byUserArray[0]->email;
			
			$updated_byUserArray = $this->user_model->getUserInfo($updated_by);
			$data['assetInfo'][0]->updated_by = $updated_byUserArray[0]->email;
            
            $this->global['pageTitle'] = 'Ecommerce : View Asset';
            
            $this->loadViews("viewAssetOld", $this->global, $data, NULL);
        }
    }
}