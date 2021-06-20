<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Unit extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('unit_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the unit list
     */
    function unitListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('unit_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->unit_model->unitListingCount($searchText);

            $returns = $this->paginationCompress('unitListing/', $count, 5);

            $data['unitRecords'] = $this->unit_model->unitListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Unit Listing';

            $this->loadViews('unit', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewUnit()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('unit_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New Unit';
            $data = array();

            $this->loadViews('addNewUnit', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new unit to the system
     */
    function postUnit()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewUnit();
            } else {
                $name = $this->input->post('name');
                

                $unitInfo = array(
                    'name' => $name,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('unit_model');
                $result = $this->unit_model->addNewUnit($unitInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New unit created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Unit creation failed'
                    );
                }

                redirect('addNewUnit');
            }
        }
    }

    /**
     * This function is used to chaange status of the unit using unit id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusUnit()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $unit_arr = $this->unit_model->getUnitInfo($id);

            $status = $unit_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $unitInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->unit_model->changeStatusUnit(
                $id,
                $unitInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load unit edit information
     * @param number $id : Optional : This is unit id
     */
    function editUnitOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('unitListing');
            }

            $data['unitInfo'] = $this->unit_model->getUnitInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit Unit';

            $this->loadViews('editUnitOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load unit view information
     * @param number $id : Optional : This is unit id
     */
    function viewUnitOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('unitListing');
            }

            $data['unitInfo'] = $this->unit_model->getUnitInfo(
                $id
            );

            $created_by = $data['unitInfo'][0]->created_by;
            $updated_by = $data['unitInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['unitInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['unitInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Unit';

            $this->loadViews('viewUnitOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the unit information
     */
    function editUnit()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editUnitOld($id);
            } else {
                $name = $this->input->post('name');
				
                $unitInfo = array();

                $unitInfo = array(
                    'name' => $name,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->unit_model->editUnit(
                    $unitInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Unit updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Unit updation failed'
                    );
                }

                redirect('unitListing');
            }
        }
    }

    /**
     * This function is used to check whether unit already exist or not
     */
    function checkUnitExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->unit_model->checkUnitExists($name);
        } else {
            $result = $this->unit_model->checkUnitExists(
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