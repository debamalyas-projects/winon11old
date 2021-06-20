<?php
class Customer_model extends CI_Model
{
    /**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function customerListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('customer');
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  contact_number  LIKE '%".$searchText."%'
                OR  email  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the customer listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function customerListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('customer');
        if(!empty($searchText)){
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  contact_number  LIKE '%".$searchText."%'
                OR  email  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        if ($page != '' && $segment != '') {
            $this->db->limit($page, $segment);
        } else {
            $this->db->limit($page, 0);
        }
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to add new customer to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCustomer($customerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('customer', $customerInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the customer information
     * @param number $id : This is customer id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCustomer($id, $customerInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('customer', $customerInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get customer information by id
     * @param number $id : This is customer id
     * @return array $result : This is customer information
     */
    function getCustomerInfo($id)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the customer information
     * @param array $customerInfo : This is customer updated information
     * @param number $id : This is customer id
     */
    function editCustomer($customerInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('customer', $customerInfo);

        return true;
    }

    /**
     * This function is used to check whether  customer is already existing or not
     * @param {string} $name : This is customer Name
     * @param {number} $id : This is customer id
     * @return {mixed} $result : This is searched result
     */
    function checkCustomerExists($email, $id = 0)
    {
        $this->db->select('email');
        $this->db->from('customer');
        $this->db->where('email', $email);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>