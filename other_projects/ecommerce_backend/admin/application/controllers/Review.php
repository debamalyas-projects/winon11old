<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Review extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('review_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the review list
     */
    function reviewListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('review_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->review_model->reviewListingCount($searchText);

            $returns = $this->paginationCompress('reviewListing/', $count, 5);

            $data['reviewRecords'] = $this->review_model->reviewListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Review Listing';

            $this->loadViews('review', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewReview()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('review_model');
			$this->load->model('product_model');
			
			$data = array();
			$data['brandRecords'] = $this->product_model->getAllProduct();
            $this->global['pageTitle'] = 'Ecommerce : Add New Review';

            $this->loadViews('addNewReview', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new review to the system
     */
    function postReview()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('contact','Contact','trim|required|xss_clean');
			$this->form_validation->set_rules('message','Message','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewReview();
            } else {
                $name = $this->input->post('name');
				$email = $this->input->post('email');
				$contact = $this->input->post('contact');
				$message = $this->input->post('message');
				$product_id = $this->input->post('product_id');
                

                $reviewInfo = array(
				'product_id'=>$product_id,
                    'name' => $name,
					'email' => $email,
					'contact' => $contact,
					'message' => $message,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('review_model');
                $result = $this->review_model->addNewReview($reviewInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New review created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Review creation failed'
                    );
                }

                redirect('addNewReview');
            }
        }
    }

    /**
     * This function is used to chaange status of the review using review id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusReview()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $review_arr = $this->review_model->getReviewInfo($id);

            $status = $review_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $reviewInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->review_model->changeStatusReview(
                $id,
                $reviewInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load review edit information
     * @param number $id : Optional : This is review id
     */
    function editReviewOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('reviewListing');
            }
			$this->load->model('product_model');
			$data['brandRecords'] = $this->product_model->getAllProduct();
            $data['reviewInfo'] = $this->review_model->getReviewInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit Review';

            $this->loadViews('editReviewOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load review view information
     * @param number $id : Optional : This is review id
     */
    function viewReviewOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('reviewListing');
            }

            $data['reviewInfo'] = $this->review_model->getReviewInfo(
                $id
            );

            $created_by = $data['reviewInfo'][0]->created_by;
            $updated_by = $data['reviewInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['reviewInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['reviewInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Review';

            $this->loadViews('viewReviewOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the review information
     */
    function editReview()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('contact','Contact','trim|required|xss_clean');
			$this->form_validation->set_rules('message','Message','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editReviewOld($id);
            } else {
                $name = $this->input->post('name');
				$email = $this->input->post('email');
				$contact = $this->input->post('contact');
				$message = $this->input->post('message');
				$product_id = $this->input->post('product_id');
                $reviewInfo = array();

                $reviewInfo = array(
				'product_id'=>$product_id,
                    'name' => $name,
					'email' => $email,
					'contact' => $contact,
					'message' => $message,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->review_model->editReview(
                    $reviewInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Review updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Review updation failed'
                    );
                }

                redirect('reviewListing');
            }
        }
    }

    /**
     * This function is used to check whether review already exist or not
     */
    function checkReviewExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->review_model->checkReviewExists($name);
        } else {
            $result = $this->review_model->checkReviewExists(
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