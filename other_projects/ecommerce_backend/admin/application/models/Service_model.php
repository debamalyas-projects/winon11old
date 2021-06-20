<?php
class Service_model extends CI_Model
{	
	/**
     * This function is used to get the service listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function serviceListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('service');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the service listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function serviceListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('service');
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
     * This function is used to add new service to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewService($serviceInfo)
    {
        $this->db->trans_start();
        $this->db->insert('service', $serviceInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the service information
     * @param number $id : This is service id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusService($id, $serviceInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('service', $serviceInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getServiceInfo($id)
    {
        $this->db->select('*');
        $this->db->from('service');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the service information
     * @param array $id : This is service updated information
     * @param number $id : This is service id
     */
    function editService($serviceInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('service', $serviceInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  service is already existing or not
     * @param {string} $name : This is service name
     * @param {number} $id : This is service id
     * @return {mixed} $result : This is searched result
     */
    function checkServiceExists($name, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("service");
        $this->db->where("name", $name);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>