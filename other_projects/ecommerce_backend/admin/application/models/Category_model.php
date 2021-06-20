<?php
class Category_model extends CI_Model
{	
	/**
     * This function is used to get the category listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function categoryListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('category');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the category listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function categoryListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('category');
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
	
	/**
     * This function is used to add new category to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCategory($categoryInfo)
    {
        $this->db->trans_start();
        $this->db->insert('category', $categoryInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the category information
     * @param number $id : This is id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCategory($id, $categoryInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('category', $categoryInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get category information by id
     * @param number $id : This is  id
     * @return array $result : This is category information
     */
    function getcategoryInfo($id)
    {
        $this->db->select('*');
        $this->db->from('category');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the category information
     * @param array $categoryInfo : This is category updated information
     * @param number $id : This is  id
     */
    function editCategory($categoryInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('category', $categoryInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  category is already existing or not
     * @param {string} $Name : This is name
     * @param {number} $id : This is  id
     * @return {mixed} $result : This is searched result
     */
    function checkCategoryExists($CategoryName, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("category");
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
        $this->db->from('category');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>