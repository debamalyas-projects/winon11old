<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Rating extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('rating_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the rating list
     */
    function ratingListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('rating_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->rating_model->ratingListingCount($searchText);

            $returns = $this->paginationCompress('ratingListing/', $count, 5);

            $data['ratingRecords'] = $this->rating_model->ratingListing($searchText,$returns['page'],$returns['segment']);
			
			
            $this->global['pageTitle'] = 'Ecommerce : Rating Listing';

            $this->loadViews('rating', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewRating()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('rating_model');
			$this->load->model('product_model');
			
			$data = array();
			$data['brandRecords'] = $this->product_model->getAllProduct();
		
            $this->global['pageTitle'] = 'Ecommerce : Add New Rating';

            $this->loadViews('addNewRating', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new rating to the system
     */
    function postRating()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('contact','Contact','trim|required|xss_clean');
			$this->form_validation->set_rules('rating_value','ratingValue','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewRating();
            } else {
                $name = $this->input->post('name');
				$email = $this->input->post('email');
				$contact = $this->input->post('contact');
				$rating_value = $this->input->post('rating_value');
				$product_id = $this->input->post('product_id');
                

                $ratingInfo = array(
					'product_id'=>$product_id,
                    'name' => $name,
					'email' => $email,
					'contact' => $contact,
					'rating_value' => $rating_value,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('rating_model');
                $result = $this->rating_model->addNewRating($ratingInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New rating created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Rating creation failed'
                    );
                }

                redirect('addNewRating');
            }
        }
    }

    /**
     * This function is used to chaange status of the rating using rating id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusRating()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $rating_arr = $this->rating_model->getRatingInfo($id);

            $status = $rating_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $ratingInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->rating_model->changeStatusRating(
                $id,
                $ratingInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load rating edit information
     * @param number $id : Optional : This is rating id
     */
    function editRatingOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('ratingListing');
            }
			$this->load->model('product_model');
            $data['ratingInfo'] = $this->rating_model->getRatingInfo(
                $id
            );
			$data['brandRecords'] = $this->product_model->getAllProduct();
            $this->global['pageTitle'] = 'Ecommerce : Edit Rating';

            $this->loadViews('editRatingOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load rating view information
     * @param number $id : Optional : This is rating id
     */
    function viewRatingOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('ratingListing');
            }

            $data['ratingInfo'] = $this->rating_model->getRatingInfo(
                $id
            );

            $created_by = $data['ratingInfo'][0]->created_by;
            $updated_by = $data['ratingInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['ratingInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['ratingInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Rating';

            $this->loadViews('viewRatingOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the rating information
     */
    function editRating()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('contact','Contact','trim|required|xss_clean');
			$this->form_validation->set_rules('rating_value','ratingValue','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editRatingOld($id);
            } else {
                $name = $this->input->post('name');
				$email = $this->input->post('email');
				$contact = $this->input->post('contact');
				$rating_value = $this->input->post('rating_value');
				$product_id = $this->input->post('product_id');

                $ratingInfo = array();

                $ratingInfo = array(
					'product_id'=>$product_id,
                    'name' => $name,
					'email' => $email,
					'contact' => $contact,
					'rating_value' => $rating_value,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->rating_model->editRating(
                    $ratingInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Rating updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Rating updation failed'
                    );
                }

                redirect('ratingListing');
            }
        }
    }

    /**
     * This function is used to check whether rating already exist or not
     */
    function checkRatingExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->rating_model->checkRatingExists($name);
        } else {
            $result = $this->rating_model->checkRatingExists(
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