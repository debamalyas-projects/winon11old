<?php
class MoneyClaim_model extends CI_Model
{	
	/**
     * This function is used to get the moneyClaim listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function moneyClaimListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('claim_amount');
        if(!empty($searchText)) {
            $likeCriteria = "ProcessingStatus  LIKE '%".$searchText."%'
                            ";
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
    function moneyClaimListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('claim_amount');
        if($searchText==1 || $searchText==0) {
            $likeCriteria = "ProcessingStatus  LIKE '%".$searchText."%'
                            ";;
            $this->db->where($likeCriteria);
        }
		
		//echo $this->db->last_query(); die();
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
	
	
}
?>