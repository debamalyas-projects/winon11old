<?php
class assetLink_model extends CI_Model
{	
	/**
     * This function is used to get the assetlink listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function assetlinkListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('assetlink');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the assetlink listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function assetlinkListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('assetlink');
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
     * This function is used to add new assetlink to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewassetLink($assetlinkInfo)
    {
        $this->db->trans_start();
        $this->db->insert('assetlink', $assetlinkInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the assetlink information
     * @param number $id : This is assetlink id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusassetLink($id, $assetlinkInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('assetlink', $assetlinkInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get assetlink information by id
     * @param number $id : This is assetlink id
     * @return array $result : This is assetlink information
     */
    function getassetLinkInfo($id)
    {
        $this->db->select('*');
        $this->db->from('assetlink');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the assetlink information
     * @param array $id : This is assetlink updated information
     * @param number $id : This is assetlink id
     */
    function editassetLink($assetlinkInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('assetlink', $assetlinkInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  assetlink is already existing or not
     * @param {string} $name : This is assetlink name
     * @param {number} $id : This is assetlink id
     * @return {mixed} $result : This is searched result
     */
    function checkassetLinkExists($name, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("assetlink");
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
        $this->db->from('asset_link');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>