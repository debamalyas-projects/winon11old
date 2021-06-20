<?php
class Content_model extends CI_Model
{	
	/**
     * This function is used to get the content listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function contentListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('content');
        if(!empty($searchText)) {
            $likeCriteria = "tag  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the content listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function contentListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('content');
        if(!empty($searchText)) {
            $likeCriteria = "tag  LIKE '%".$searchText."%'";
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
     * This function is used to add new content to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewContent($contentInfo)
    {
        $this->db->trans_start();
        $this->db->insert('content', $contentInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the content information
     * @param number $id : This is content id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusContent($id, $contentInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('content', $contentInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get content information by id
     * @param number $id : This is content id
     * @return array $result : This is content information
     */
    function getContentInfo($id)
    {
        $this->db->select('*');
        $this->db->from('content');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the content information
     * @param array $id : This is content updated information
     * @param number $id : This is content id
     */
    function editContent($contentInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('content', $contentInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  content is already existing or not
     * @param {string} $tag : This is content tag
     * @param {number} $id : This is content id
     * @return {mixed} $result : This is searched result
     */
    function checkContentExists($tag, $id = 0)
    {
        $this->db->select("tag");
        $this->db->from("content");
        $this->db->where("tag", $tag);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>