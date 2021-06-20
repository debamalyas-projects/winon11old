<?php
class Attribute_model extends CI_Model
{
    /**
     * This function is used to get the attribute listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function attributeListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('attribute');
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the attribute listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function attributeListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('attribute');
        if(!empty($searchText)){
            $likeCriteria="name  LIKE '%".$searchText."%'";
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
     * This function is used to add new attribute to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewAttribute($attributeInfo)
    {
        $this->db->trans_start();
        $this->db->insert('attribute', $attributeInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the attribute information
     * @param number $id : This is attribute id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusAttribute($id, $attributeInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('attribute', $attributeInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get attribute information by id
     * @param number $id : This is attribute id
     * @return array $result : This is attribute information
     */
    function getAttributeInfo($id)
    {
        $this->db->select('*');
        $this->db->from('attribute');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the attribute information
     * @param array $attributeInfo : This is attribute updated information
     * @param number $id : This is attribute id
     */
    function editAttribute($attributeInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('attribute', $attributeInfo);

        return true;
    }

    /**
     * This function is used to check whether  attribute is already existing or not
     * @param {string} $name : This is Attribute Name
     * @param {number} $id : This is attribute id
     * @return {mixed} $result : This is searched result
     */
    function checkAttributeExists($name, $id = 0)
    {
        $this->db->select('name');
        $this->db->from('attribute');
        $this->db->where('name', $name);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
	function getAllBrand()
    {
        $this->db->select('*');
        $this->db->from('attribute');
        $query = $this->db->get();
        
        return $query->result();
    }
}
?>