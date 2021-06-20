<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Customer extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
		
		$this->load->helper('email');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the customer list
     */
    function customerListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('customer_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->customer_model->customerListingCount($searchText);

            $returns = $this->paginationCompress('customerListing/', $count, 5);

            $data['customerRecords'] = $this->customer_model->customerListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Customer Listing';

            $this->loadViews('customer', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewCustomer()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('customer_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New Customer';
            $data = array();

            $this->loadViews('addNewCustomer', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new customer to the system
     */
    function postCustomer()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('contact_number','Contact Number','trim|required|xss_clean');
			$this->form_validation->set_rules('email','email','trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('shipping_address','shipping_adress','trim|required|xss_clean');
			$this->form_validation->set_rules('billing_address','billing_address','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewCustomer();
            } else {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$shipping_address = $this->input->post('shipping_address');
				$billing_address = $this->input->post('billing_address');
                

                $customerInfo = array(
                    'name' => $name,
					'contact_number' => $contact_number,
					'email' => $email,
					'shipping_address' => $shipping_address,
					'billing_address' => $billing_address,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('customer_model');
                $result = $this->customer_model->addNewCustomer($customerInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New customer created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Customer creation failed'
                    );
                }

                redirect('addNewCustomer');
            }
        }
    }

    /**
     * This function is used to chaange status of the customer using customer id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCustomer()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $customer_arr = $this->customer_model->getCustomerInfo($id);

            $status = $customer_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $customerInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->customer_model->changeStatusCustomer(
                $id,
                $customerInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load customer edit information
     * @param number $id : Optional : This is customer id
     */
    function editCustomerOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('customerListing');
            }

            $data['customerInfo'] = $this->customer_model->getcustomerInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit customer';

            $this->loadViews('editCustomerOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load customer view information
     * @param number $id : Optional : This is customer id
     */
    function viewCustomerOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('customerListing');
            }

            $data['customerInfo'] = $this->customer_model->getcustomerInfo(
                $id
            );

            $created_by = $data['customerInfo'][0]->created_by;
            $updated_by = $data['customerInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['customerInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['customerInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View customer';

            $this->loadViews('viewCustomerOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the customer information
     */
    function editCustomer()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('contact_number','Contact Number','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('shipping_address','Shipping Address','trim|required|xss_clean');
			$this->form_validation->set_rules('billing_address','Billing Address','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editCustomerOld($id);
            } else {
                $name = $this->input->post('name');
				$contact_number = $this->input->post('contact_number');
				$email = $this->input->post('email');
				$shipping_address = $this->input->post('shipping_address');
				$billing_address = $this->input->post('billing_address');

                $customerInfo = array();

                $customerInfo = array(
                    'name' => $name,
					'contact_number' => $contact_number,
					'email' => $email,
					'shipping_address' => $shipping_address,
					'billing_address' => $billing_address,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );
				
                $result = $this->customer_model->editCustomer(
                    $customerInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Customer updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Customer updation failed'
                    );
                }

                redirect('customerListing');
            }
        }
    }

    /**
     * This function is used to check whether customer already exist or not
     */
    function checkCustomerExists()
    {
        $id = $this->input->post('id');
        $email = $this->input->post('email');

        if (empty($id)) {
            $result = $this->customer_model->checkCustomerExists($email);
        } else {
            $result = $this->customer_model->checkCustomerExists(
                $email,
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