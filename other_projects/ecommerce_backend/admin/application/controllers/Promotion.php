<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Promotion extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('promotion_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the promotion list
     */
    function promotionListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('promotion_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->promotion_model->promotionListingCount($searchText);

            $returns = $this->paginationCompress('promotionListing/', $count, 5);

            $data['promotionRecords'] = $this->promotion_model->promotionListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Promotion Listing';

            $this->loadViews('promotion', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewPromotion()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('promotion_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New Promotion';
            $data = array();

            $this->loadViews('addNewPromotion', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new promotion to the system
     */
    function postPromotion()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('subject','Subject','required');
			$this->form_validation->set_rules('content','Content','required');
            

            if ($this->form_validation->run() == false) {
                $this->addNewPromotion();
            } else {
                $subject = $this->input->post('subject');
				$content = $this->input->post('content');
                

                $promotionInfo = array(
                    'subject' => $subject,
					'content' => $content,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('promotion_model');
                $result = $this->promotion_model->addNewPromotion($promotionInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New promotion created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Promotion creation failed'
                    );
                }

                redirect('addNewPromotion');
            }
        }
    }

    /**
     * This function is used to chaange status of the promotion using promotion id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusPromotion()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $promotion_arr = $this->promotion_model->getPromotionInfo($id);

            $status = $promotion_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $promotionInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->promotion_model->changeStatusPromotion(
                $id,
                $promotionInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load promotion edit information
     * @param number $id : Optional : This is promotion id
     */
    function editPromotionOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('promotionListing');
            }

            $data['promotionInfo'] = $this->promotion_model->getPromotionInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit Promotion';

            $this->loadViews('editPromotionOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load promotion view information
     * @param number $id : Optional : This is promotion id
     */
    function viewPromotionOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('promotionListing');
            }

            $data['promotionInfo'] = $this->promotion_model->getPromotionInfo(
                $id
            );

            $created_by = $data['promotionInfo'][0]->created_by;
            $updated_by = $data['promotionInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['promotionInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['promotionInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Promotion';

            $this->loadViews('viewPromotionOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the promotion information
     */
    function editPromotion()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('subject','Subject','required');
			$this->form_validation->set_rules('content','Content','required');

            if ($this->form_validation->run() == false) {
                $this->editPromotionOld($id);
            } else {
                $subject = $this->input->post('subject');
				$content = $this->input->post('content');
				
                $promotionInfo = array();

                $promotionInfo = array(
                    'subject' => $subject,
					'content' => $content,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->promotion_model->editPromotion(
                    $promotionInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Promotion updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Promotion updation failed'
                    );
                }

                redirect('promotionListing');
            }
        }
    }

    /**
     * This function is used to check whether promotion already exist or not
     */
    function checkPromotionExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->promotion_model->checkPromotionExists($name);
        } else {
            $result = $this->promotion_model->checkPromotionExists(
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