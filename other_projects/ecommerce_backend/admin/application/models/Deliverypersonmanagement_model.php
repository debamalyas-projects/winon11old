<?php
class Deliverypersonmanagement_model extends CI_Model
{	
	/**
     * This function is used to get the delivery person listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function deliverypersonmanagementListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('delivery_person');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'
                            OR  contact_number  LIKE '%".$searchText."%'
							OR  email  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the delivery person listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function deliverypersonmanagementListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('delivery_person');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'
                            OR  contact_number  LIKE '%".$searchText."%'
							OR  email  LIKE '%".$searchText."%'";
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
     * This function is used to add new delivery person to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewDeliverypersonmanagement($deliverypersonmanagementInfo)
    {
        $this->db->trans_start();
        $this->db->insert('delivery_person', $deliverypersonmanagementInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the delivery person information
     * @param number $id : This is delivery person id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusDeliverypersonmanagement($id, $deliverypersonmanagementInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('delivery_person', $deliverypersonmanagementInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get delivery person information by id
     * @param number $id : This is delivery person id
     * @return array $result : This is delivery person information
     */
    function getDeliverypersonmanagementInfo($id)
    {
        $this->db->select('*');
        $this->db->from('delivery_person');
		$this->db->where('ID', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the delivery person information
     * @param array $deliverypersonmanagementInfo : This is delivery person updated information
     * @param number $id : This is delivery person id
     */
    function editDeliverypersonmanagement($deliverypersonmanagementInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('delivery_person', $deliverypersonmanagementInfo);
        
        return TRUE;
    }
	
	/**
     * This function is used to check whether  delivery person is already existing or not
     * @param {string} $email : This is Delivery Person Email
     * @param {number} $id : This is delivery person id
     * @return {mixed} $result : This is searched result
     */
    function checkDeliverypersonmanagementExists($email, $id = 0)
    {
        $this->db->select("email");
        $this->db->from("delivery_person");
        $this->db->where("email", $email);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>