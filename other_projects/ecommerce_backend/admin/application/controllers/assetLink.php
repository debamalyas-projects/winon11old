<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class assetLink extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('assetlink_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the assetlink list
     */
    function assetlinkListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('assetlink_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->assetlink_model->assetlinkListingCount($searchText);

            $returns = $this->paginationCompress('assetlinkListing/', $count, 5);

            $data['assetlinkRecords'] = $this->assetlink_model->assetlinkListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : assetLink Listing';

            $this->loadViews('assetlink', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewassetLink()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('assetlink_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New assetLink';
            $data = array();

            $this->loadViews('addNewassetLink', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new assetlink to the system
     */
    function postassetLink()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewassetLink();
            } else {
                $name = $this->input->post('name');
				$link = $this->input->post('link');
                

                $assetlinkInfo = array(
                    'name' => $name,
					'link' => $link,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('assetlink_model');
                $result = $this->assetlink_model->addNewassetLink($assetlinkInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New assetlink created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'assetLink creation failed'
                    );
                }

                redirect('addNewassetLink');
            }
        }
    }

    /**
     * This function is used to chaange status of the assetlink using assetlink id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusassetLink()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $assetlink_arr = $this->assetlink_model->getassetLinkInfo($id);

            $status = $assetlink_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $assetlinkInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->assetlink_model->changeStatusassetLink(
                $id,
                $assetlinkInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load assetlink edit information
     * @param number $id : Optional : This is assetlink id
     */
    function editassetLinkOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('assetlinkListing');
            }

            $data['assetlinkInfo'] = $this->assetlink_model->getassetLinkInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit assetLink';

            $this->loadViews('editassetLinkOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load assetlink view information
     * @param number $id : Optional : This is assetlink id
     */
    function viewassetLinkOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('assetlinkListing');
            }

            $data['assetlinkInfo'] = $this->assetlink_model->getassetLinkInfo(
                $id
            );

            $created_by = $data['assetlinkInfo'][0]->created_by;
            $updated_by = $data['assetlinkInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['assetlinkInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['assetlinkInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View assetLink';

            $this->loadViews('viewassetLinkOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the assetlink information
     */
    function editassetLink()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editassetLinkOld($id);
            } else {
                $name = $this->input->post('name');
				$link = $this->input->post('link');
				
                $assetlinkInfo = array();

                $assetlinkInfo = array(
                    'name' => $name,
					'link' => $link,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->assetlink_model->editassetLink(
                    $assetlinkInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'assetLink updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'assetLink updation failed'
                    );
                }

                redirect('assetlinkListing');
            }
        }
    }

    /**
     * This function is used to check whether assetlink already exist or not
     */
    function checkassetLinkExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->assetlink_model->checkassetLinkExists($name);
        } else {
            $result = $this->assetlink_model->checkassetLinkExists(
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