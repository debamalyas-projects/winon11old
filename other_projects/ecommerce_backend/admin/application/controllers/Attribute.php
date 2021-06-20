<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Attribute extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('attribute_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Ecommerce : Dashboard';

        $this->loadViews('dashboard', $this->global, null, null);
    }

    /**
     * This function is used to load the attribute list
     */
    function attributeListing()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('attribute_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->attribute_model->attributeListingCount($searchText);

            $returns = $this->paginationCompress('attributeListing/', $count, 5);

            $data['attributeRecords'] = $this->attribute_model->attributeListing($searchText,$returns['page'],$returns['segment']);

            $this->global['pageTitle'] = 'Ecommerce : Attribute Listing';

            $this->loadViews('attribute', $this->global, $data, null);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewAttribute()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->model('attribute_model');

            $this->global['pageTitle'] = 'Ecommerce : Add New Attribute';
            $data = array();

            $this->loadViews('addNewAttribute', $this->global, $data, null);
        }
    }

    /**
     * This function is used to add new attribute to the system
     */
    function postAttribute()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            

            if ($this->form_validation->run() == false) {
                $this->addNewAttribute();
            } else {
                $name = $this->input->post('name');
                

                $attributeInfo = array(
                    'name' => $name,
                    'created_by' => $this->vendorId,
                    'updated_by' => $this->vendorId,
                    'created_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $this->load->model('attribute_model');
                $result = $this->attribute_model->addNewAttribute($attributeInfo);

                if ($result > 0) {
                    $this->session->set_flashdata(
                        'success',
                        'New attribute created successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Attribute creation failed'
                    );
                }

                redirect('addNewAttribute');
            }
        }
    }

    /**
     * This function is used to chaange status of the attribute using attribute id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusAttribute()
    {
        if ($this->isAdmin() == true) {
            echo json_encode(['status' => 'access']);
        } else {
            $id = $this->input->post('id');

            $attribute_arr = $this->attribute_model->getAttributeInfo($id);

            $status = $attribute_arr[0]->status;

            if ($status == '0') {
                $statusVal = '1';
            } else {
                $statusVal = '0';
            }
            $attributeInfo = array(
                'status' => $statusVal,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            $result = $this->attribute_model->changeStatusAttribute(
                $id,
                $attributeInfo
            );

            if ($result > 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
    }

    /**
     * This function is used load attribute edit information
     * @param number $id : Optional : This is attribute id
     */
    function editAttributeOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('attributeListing');
            }

            $data['attributeInfo'] = $this->attribute_model->getAttributeInfo(
                $id
            );

            $this->global['pageTitle'] = 'Ecommerce : Edit Attribute';

            $this->loadViews('editAttributeOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used load attribute view information
     * @param number $id : Optional : This is attribute id
     */
    function viewAttributeOld($id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($id == null) {
                redirect('attributeListing');
            }

            $data['attributeInfo'] = $this->attribute_model->getAttributeInfo(
                $id
            );

            $created_by = $data['attributeInfo'][0]->created_by;
            $updated_by = $data['attributeInfo'][0]->updated_by;

            $created_byUserArray = $this->user_model->getUserInfo($created_by);

            $data['attributeInfo'][0]->created_by = $created_byUserArray[0]->email;

            $updated_byUserArray = $this->user_model->getUserInfo($updated_by);
            $data['attributeInfo'][0]->updated_by = $updated_byUserArray[0]->email;

            $this->global['pageTitle'] = 'Ecommerce : View Attribute';

            $this->loadViews('viewAttributeOld', $this->global, $data, null);
        }
    }

    /**
     * This function is used to edit the attribute information
     */
    function editAttribute()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->editAttributeOld($id);
            } else {
                $name = $this->input->post('name');
				
                $attributeInfo = array();

                $attributeInfo = array(
                    'name' => $name,
                    'updated_by' => $this->vendorId,
                    'updated_on' => date('Y-m-d H:i:s')
                );

                $result = $this->attribute_model->editAttribute(
                    $attributeInfo,
                    $id
                );

                if ($result == true) {
                    $this->session->set_flashdata(
                        'success',
                        'Attribute updated successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Attribute updation failed'
                    );
                }

                redirect('attributeListing');
            }
        }
    }

    /**
     * This function is used to check whether attribute already exist or not
     */
    function checkAttributeExists()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if (empty($id)) {
            $result = $this->attribute_model->checkAttributeExists($name);
        } else {
            $result = $this->attribute_model->checkAttributeExists(
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