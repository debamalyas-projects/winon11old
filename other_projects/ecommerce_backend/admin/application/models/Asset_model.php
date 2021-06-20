<?php
class Asset_model extends CI_Model
{	
	/**
     * This function is used to get the asset listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function assetListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('asset');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the asset listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function assetListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('asset');
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
     * This function is used to add new asset to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewAsset($assetInfo)
    {
        $this->db->trans_start();
        $this->db->insert('asset', $assetInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the asset information
     * @param number $id : This is asset id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusAsset($id, $assetInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('asset', $assetInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get asset information by id
     * @param number $id : This is asset id
     * @return array $result : This is asset information
     */
    function getAssetInfo($id)
    {
        $this->db->select('*');
        $this->db->from('asset');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the asset information
     * @param array $id : This is asset updated information
     * @param number $id : This is asset id
     */
    function editAsset($assetInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('asset', $assetInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  asset is already existing or not
     * @param {string} $name : This is asset name
     * @param {number} $id : This is asset id
     * @return {mixed} $result : This is searched result
     */
    function checkAssetExists($name, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("asset");
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
        $this->db->from('asset');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>