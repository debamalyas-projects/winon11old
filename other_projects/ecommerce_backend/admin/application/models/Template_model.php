<?php
class Template_model extends CI_Model
{	
	/**
     * This function is used to get the template listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function templateListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('template');
        if(!empty($searchText)) {
            $likeCriteria = "name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the template listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function templateListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('template');
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
     * This function is used to add new template to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewTemplate($templateInfo)
    {
        $this->db->trans_start();
        $this->db->insert('template', $templateInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the template information
     * @param number $id : This is template id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusTemplate($id, $templateInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('template', $templateInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get template information by id
     * @param number $id : This is template id
     * @return array $result : This is template information
     */
    function getTemplateInfo($id)
    {
        $this->db->select('*');
        $this->db->from('template');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the template information
     * @param array $id : This is template updated information
     * @param number $id : This is template id
     */
    function editTemplate($templateInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('template', $templateInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  template is already existing or not
     * @param {string} $name : This is template name
     * @param {number} $id : This is template id
     * @return {mixed} $result : This is searched result
     */
    function checkTemplateExists($name, $id = 0)
    {
        $this->db->select("name");
        $this->db->from("template");
        $this->db->where("name", $name);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>