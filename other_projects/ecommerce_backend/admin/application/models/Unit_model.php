<?php
class Unit_model extends CI_Model
{
    /**
     * This function is used to get the unit listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function unitListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('unit');
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the unit listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function unitListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('unit');
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
     * This function is used to add new unit to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUnit($unitInfo)
    {
        $this->db->trans_start();
        $this->db->insert('unit', $unitInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the unit information
     * @param number $id : This is unit id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusUnit($id, $unitInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('unit', $unitInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get unit information by id
     * @param number $id : This is unit id
     * @return array $result : This is unit information
     */
    function getUnitInfo($id)
    {
        $this->db->select('*');
        $this->db->from('unit');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the unit information
     * @param array $unitInfo : This is unit updated information
     * @param number $id : This is unit id
     */
    function editUnit($unitInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('unit', $unitInfo);

        return true;
    }

    /**
     * This function is used to check whether  unit is already existing or not
     * @param {string} $name : This is Unit Name
     * @param {number} $id : This is unit id
     * @return {mixed} $result : This is searched result
     */
    function checkUnitExists($name, $id = 0)
    {
        $this->db->select('name');
        $this->db->from('unit');
        $this->db->where('name', $name);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
	function getAllUnit()
    {
        $this->db->select('*');
        $this->db->from('unit');
        $query = $this->db->get();
        
        return $query->result();
    }
	function getUnitProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('unit');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }
}
?>