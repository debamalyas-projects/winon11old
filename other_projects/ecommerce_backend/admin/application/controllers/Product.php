<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Product extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the product list
     */
    function productListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('product_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->product_model->productListingCount($searchText);

            $returns = $this->paginationCompress('productListing/', $count, 5);

            $data['productRecords'] = $this->product_model->productListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Product Listing';

            $this->loadViews('product', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewProduct()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('product_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New Product';
            $data = array();
			
			$this->load->model('brand_model');
			$brand['brandRecords'] = $this->brand_model->productbrandListing();
			
			$this->load->model('unit_model');
			$brand['unitRecords'] = $this->unit_model->getAllUnit();
			
            $this->loadViews('addNewProduct', $this->global, $brand, null);
        }
    }

    /**
     * This function is used to add new product to the system
     */
    function postProduct()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
			$this->form_validation->set_rules('specification','Specification','trim|required|xss_clean');
			$this->form_validation->set_rules('tags','Tags','trim|required|xss_clean');
			$this->form_validation->set_rules('brand','Brand','required');
            $this->form_validation->set_rules('unit','Unit','required');
			$this->form_validation->set_rules('club_discount','Club_discount','required');

            if ($this->form_validation->run() == false) {
                $this->addNewProduct();
            } else {
                $name = $this->input->post('name');
				$description = $this->input->post('description');
				$specification = $this->input->post('specification');
				$brand = $this->input->post('brand');
				$tags = $this->input->post('tags');
				$unit = $this->input->post('unit');
				$club_discount = $this->input->post('club_discount');
				$permalink = strtolower($name);
				$permalink = explode(" ",$permalink);
				$permalink = implode("-",$permalink);
				
				
                $productInfo = array(
                    'name' => $name,
					'description' => $description,
					'specification' => $specification,
					'brand' => $brand,
					'permalink'=>$permalink,
					'tags'=>$tags,
					'unit'=>$unit,
					'club_discount'=>$club_discount,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('product_model');
                $result = $this->product_model->addNewProduct($productInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New product created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Product creation failed'
                    );
                }

                redirect('addNewProduct');
            }
        }
    }

    /**
     * This function is used to chaange status of the product using product id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProduct()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $product_arr = $this->product_model->getProductInfo($id);

            $status = $product_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $productInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->product_model->changeStatusProduct(
                $id,
                $productInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load product edit information
     * @param number $id : Optional : This is product id
     */
    function editProductOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('productListing');
            }

            $data['productInfo'] = $this->product_model->getProductInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit Product';
		
			$this->load->model('brand_model');
			$this->load->model('unit_model');
			
			$brand['brandInfo'] = $this->brand_model->getBrandProductInfo($data['productInfo'][0]->brand);
			$data['unitInfo'] = $this->unit_model->getAllUnit($data['productInfo'][0]->unit);
			
			
			$this->load->model('brand_model');
			$brandR['brandRecords'] = $this->brand_model->productbrandListing();
				
			$data['productInfo'] = array_merge($data['productInfo'],$brand['brandInfo'],$brandR['brandRecords']);
            $this->loadViews('editProductOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load product view information
     * @param number $id : Optional : This is product id
     */
    function viewProductOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('productListing');
            }

            $data['productInfo'] = $this->product_model->getProductInfo(
                $id
            );

            $created_by = $data['productInfo'][0]->created_by;
            $updated_by = $data['productInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['productInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['productInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Product';

			
			//$this->loadViews('viewProductOld', $this->global, $data, null);
			
			$this->load->model('brand_model');
			$this->load->model('unit_model');
			
			
			$brand['brandInfo'] = $this->brand_model->getBrandProductInfo($data['productInfo'][0]->brand);
			
			$data['productInfo'] = array_merge($data['productInfo'],$brand['brandInfo']);
			
			$data['unitInfo'] = $this->unit_model->getUnitProductInfo($data['productInfo'][0]->unit);
			
		
			
			$this->loadViews('viewProductOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the product information
     */
    function editProduct()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
			$this->form_validation->set_rules('specification','Specification','trim|required|xss_clean');
			$this->form_validation->set_rules('tags','Tags','trim|required|xss_clean');
			$this->form_validation->set_rules('brand','Brand','required');
			$this->form_validation->set_rules('unit','Unit','required');
			$this->form_validation->set_rules('club_discount','Club_discount','required');

            if ($this->form_validation->run() == false) {
                $this->editOld($id);
            } else {
                $name = $this->input->post('name');
				$tags = $this->input->post('tags');
				$unit = $this->input->post('unit');
				$description = $this->input->post('description');
				$specification = $this->input->post('specification');
				$brand = $this->input->post('brand');
				$club_discount = $this->input->post('club_discount');

                $productInfo = array();

                $productInfo = array(
                    'name' => $name,
					'description' => $description,
					'specification' => $specification,
					'brand' => $brand,
					'club_discount'=>$club_discount,
					'tags'=>$tags,
					'unit'=>$unit,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->product_model->editProduct(
                    $productInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Product updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Product updation failed'
                    );
                }

                redirect('productListing');
            }
        }
    }

    /**
     * This function is used to check whether product already exist or not
     */
    function checkProductExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->product_model->checkProductExists($name);
        } else {
            $result = $this->product_model->checkProductExists(
                $name,
                $id
            );
        }

        if (empty($result)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
}
?>