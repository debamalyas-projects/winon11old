<?php
class Vendor_model extends CI_Model
{	
	/**
     * This function is used to get the vendor listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function vendorListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('vendor');
        if(!empty($searchText)) {
            $likeCriteria ="name  LIKE '%".$searchText."%'
			OR email LIKE '%".$searchText."%'
			OR contact_number LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the vendor listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function vendorListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('vendor');
        if(!empty($searchText)) {
            $likeCriteria ="name  LIKE '%".$searchText."%'
			OR email LIKE '%".$searchText."%'
			OR contact_number LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
		if($page!='' && $segment!=''){
			$this->db->limit($page, $segment);
		}else{
			$this->db->limit($page, 0);
		}
        $query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
    }
	
	/**
     * This function is used to add new vendor to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewVendor($vendorInfo)
    {
        $this->db->trans_start();
        $this->db->insert('vendor', $vendorInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the vendor information
     * @param number $id : This is vendor id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusVendor($id, $vendorInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('vendor', $vendorInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get vendor information by id
     * @param number $id : This is vendor id
     * @return array $result : This is vendor information
     */
    function getVendorInfo($id)
    {
        $this->db->select('*');
        $this->db->from('vendor');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the vendor information
     * @param array $vendorInfo : This is vendor updated information
     * @param number $id : This is vendor id
     */
    function editVendor($vendorInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('vendor', $vendorInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor is already existing or not
     * @param {string} $email : This is Vendor email
     * @param {number} $id : This is vendor id
     * @return {mixed} $result : This is searched result
     */
    function checkVendorExists($email, $id = 0)
    {
        $this->db->select('email');
        $this->db->from('vendor');
        $this->db->where('email', $email);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getAllVendor(){
		$this->db->select('*');
        $this->db->from('vendor');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>