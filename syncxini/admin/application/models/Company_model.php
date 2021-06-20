<?php
class Company_model extends CI_Model
{	
	/**
     * This function is used to get the company listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function companyListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('company');
        if(!empty($searchText)) {
            $likeCriteria = "(CompanyName  LIKE '%".$searchText."%'
                            OR  CompanyCode  LIKE '%".$searchText."%'
                            OR  InstrumentType  LIKE '%".$searchText."%'
							OR  Segment  LIKE '%".$searchText."%'
							OR  Exchange  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the company listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function companyListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('company');
        if(!empty($searchText)) {
            $likeCriteria = "(CompanyName  LIKE '%".$searchText."%'
                            OR  CompanyCode  LIKE '%".$searchText."%'
                            OR  InstrumentType  LIKE '%".$searchText."%'
							OR  Segment  LIKE '%".$searchText."%'
							OR  Exchange  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Status', '1');
		
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
     * This function is used to add new company to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCompany($companyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('company', $companyInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the company information
     * @param number $companyId : This is company id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCompany($companyId, $companyInfo)
    {
        $this->db->where('ID', $companyId);
        $this->db->update('company', $companyInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get company information by id
     * @param number $companyId : This is company id
     * @return array $result : This is company information
     */
    function getcompanyInfo($companyId)
    {
        $this->db->select('*');
        $this->db->from('company');
		$this->db->where('ID', $companyId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the company information
     * @param array $companyInfo : This is company updated information
     * @param number $companyId : This is company id
     */
    function editCompany($companyInfo, $companyId)
    {
        $this->db->where('ID', $companyId);
        $this->db->update('company', $companyInfo);
        
        return TRUE;
    }
	
	/**
     * This function is used to check whether  company is already existing or not
     * @param {string} $CompanyCode : This is CompanyCode
     * @param {number} $companyId : This is company id
     * @return {mixed} $result : This is searched result
     */
    function checkCompanyExists($CompanyCode, $companyId = 0)
    {
        $this->db->select("CompanyCode");
        $this->db->from("company");
        $this->db->where("CompanyCode", $CompanyCode);
        if($companyId != 0){
            $this->db->where("ID !=", $companyId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	/**
     * This function is used to get the company history listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function companyHistoryListingCount($searchText = '',$companyId)
    {
        $this->db->select('*');
        $this->db->from('companyhistoricaldata');
        if(!empty($searchText)) {
            $likeCriteria = "(Date  LIKE '%".$searchText."%'
                            OR  OpenPrice  LIKE '%".$searchText."%'
                            OR  HighPrice  LIKE '%".$searchText."%'
							OR  LowPrice  LIKE '%".$searchText."%'
							OR  ClosePrice  LIKE '%".$searchText."%'
							OR  Volume  LIKE '%".$searchText."%'
							OR  CreatedOn  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
		$this->db->where('CompanyID', $companyId);
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the company history listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function companyHistoryListing($searchText = '', $page, $segment,$companyId)
    {
		$this->db->select('*');
        $this->db->from('companyhistoricaldata');
        if(!empty($searchText)) {
            $likeCriteria = "(Date  LIKE '%".$searchText."%'
                            OR  OpenPrice  LIKE '%".$searchText."%'
                            OR  HighPrice  LIKE '%".$searchText."%'
							OR  LowPrice  LIKE '%".$searchText."%'
							OR  ClosePrice  LIKE '%".$searchText."%'
							OR  Volume  LIKE '%".$searchText."%'
							OR  CreatedOn  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
		$this->db->where('CompanyID', $companyId);
		$this->db->order_by('ID DESC');
		//$this->db->limit($page, $segment);
		//echo $this->db->last_query(); die();
        $query = $this->db->get();
        
        $result = $query->result();   
		//print_r($result); die();
        return $result;
    }
}
?>