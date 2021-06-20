<?php
class Zone_model extends CI_Model
{	
	/**
     * This function is used to get the zone listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function zoneListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('zones');
        if(!empty($searchText)) {
            $likeCriteria = "ZoneName  LIKE '%".$searchText."%'
                            OR  ZoneOrder  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the zone listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function zoneListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('zones');
        if(!empty($searchText)) {
            $likeCriteria = "ZoneName  LIKE '%".$searchText."%'
                            OR  ZoneOrder  LIKE '%".$searchText."%'";
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
     * This function is used to add new zone to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewZone($zoneInfo)
    {
        $this->db->trans_start();
        $this->db->insert('zones', $zoneInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the zone information
     * @param number $zoneId : This is zone id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusZone($zoneId, $zoneInfo)
    {
        $this->db->where('ID', $zoneId);
        $this->db->update('zones', $zoneInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get zone information by id
     * @param number $zoneId : This is zone id
     * @return array $result : This is zone information
     */
    function getzoneInfo($zoneId)
    {
        $this->db->select('*');
        $this->db->from('zones');
		$this->db->where('ID', $zoneId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the zone information
     * @param array $zoneInfo : This is zone updated information
     * @param number $zoneId : This is zone id
     */
    function editZone($zoneInfo, $zoneId)
    {
        $this->db->where('ID', $zoneId);
        $this->db->update('zones', $zoneInfo);
        
        return TRUE;
    }
	
	/**
     * This function is used to check whether  zone is already existing or not
     * @param {string} $ZoneName : This is ZoneName
     * @param {number} $zoneId : This is zone id
     * @return {mixed} $result : This is searched result
     */
    function checkZoneExists($ZoneName, $zoneId = 0)
    {
        $this->db->select("ZoneName");
        $this->db->from("zones");
        $this->db->where("ZoneName", $ZoneName);
        if($zoneId != 0){
            $this->db->where("ID !=", $zoneId);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>