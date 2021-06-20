<?php
class Brand_model extends CI_Model
{	
	/**
     * This function is used to get the brand listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function brandListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('brand');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the brand listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function brandListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('brand');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
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
	
	
	function productbrandListing()
    {
        $this->db->select('*');
        $this->db->from('brand');
		$this->db->where('status','1');
        $query = $this->db->get();
        
        $result = $query->result();
		return $result;
    }
	
	
	function getBrandProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('brand');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }
	
	/**
     * This function is used to add new brand to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewBrand($brandInfo)
    {
        $this->db->trans_start();
        $this->db->insert('brand', $brandInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the brand information
     * @param number $id : This is brand id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusBrand($id, $brandInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('brand', $brandInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get brand information by id
     * @param number $id : This is brand id
     * @return array $result : This is brand information
     */
    function getBrandInfo($id)
    {
        $this->db->select('*');
        $this->db->from('brand');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the brand information
     * @param array $id : This is brand updated information
     * @param number $id : This is brand id
     */
    function editBrand($brandInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('brand', $brandInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  brand is already existing or not
     * @param {string} $name : This is brand name
     * @param {number} $id : This is brand id
     * @return {mixed} $result : This is searched result
     */
    function checkBrandExists($name, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("brand");
        $this->db->where("name", $name);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getAllBrand()
	{
		$this->db->select('*');
        $this->db->from('brand');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>