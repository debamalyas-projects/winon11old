<?php
class Customer_model extends CI_Model
{	
	/**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function customerListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('customers');
        if(!empty($searchText)) {
            $likeCriteria = "FirstName  LIKE '%".$searchText."%'
                            OR  LastName  LIKE '%".$searchText."%'
							OR  EmailAddress  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the customer listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function customerListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('customers');
        if(!empty($searchText)) {
            $likeCriteria = "FirstName  LIKE '%".$searchText."%'
                            OR  LastName  LIKE '%".$searchText."%'
							OR  EmailAddress  LIKE '%".$searchText."%'";
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
     * This function is used to add new customer to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCustomer($customerInfo,$customerDetailsInfo,$customerPanFileInfo,$customerBankProofFileInfo)
    {
        $this->db->trans_start();
        $this->db->insert('customers', $customerInfo);
        
        $insert_id = $this->db->insert_id();
		
		$customerDetailsInfo['CustomerID'] = $insert_id;
		$customerPanFileInfo['CustomerID'] = $insert_id;
		$customerBankProofFileInfo['CustomerID'] = $insert_id;
		
		$this->db->insert('customerinformation', $customerDetailsInfo);
		
		$this->db->insert('customerpancardfile', $customerPanFileInfo);
		
		$this->db->insert('customerbankprooffile', $customerBankProofFileInfo);
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to add new customer to system using API
     * @return number $insert_id : This is last inserted id
     */
    function addNewCustomerApi($customerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('customers', $customerInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	function loginApi($EmailAddress,$Password){
		$this->db->select('*');
        $this->db->from('customers');
        $this->db->where('`EmailAddress`="'.$EmailAddress.'" AND `Password`="'.$Password.'"');
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
	}
	
	function updateAccessToken($access_token,$customerId){
		$customerInfo = array('AccessToken'=>$access_token);
		$this->db->where('ID', $customerId);
        $this->db->update('customers', $customerInfo);
        
        return $this->db->affected_rows();
	}
	
	function checkLoggedIn($customerId,$AccessToken){
		$this->db->select('*');
        $this->db->from('customers');
        $this->db->where('`ID`="'.$customerId.'" AND `AccessToken`="'.$AccessToken.'"');
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
	}
	
	/**
     * This function is used to delete the customer information
     * @param number $customerId : This is customer id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusCustomer($customerId, $customerInfo)
    {
        $this->db->where('ID', $customerId);
        $this->db->update('customers', $customerInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get customer information by id
     * @param number $customerId : This is customer id
     * @return array $result : This is customer information
     */
    function getcustomerInfo($customerId)
    {
        $this->db->select('*');
        $this->db->from('customers');
		$this->db->where('ID', $customerId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getCustomerDetailsInfo($customerId)
    {
        $this->db->select('*');
        $this->db->from('customerinformation');
		$this->db->where('CustomerID', $customerId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getCustomerPanFileInfo($customerId)
    {
        $this->db->select('*');
        $this->db->from('customerpancardfile');
		$this->db->where('CustomerID', $customerId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getCustomerBankProofFileInfo($customerId)
    {
        $this->db->select('*');
        $this->db->from('customerbankprooffile');
		$this->db->where('CustomerID', $customerId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the customer information
     * @param array $customerInfo : This is customer updated information
     * @param number $customerId : This is customer id
     */
    function editCustomer($customerInfo, $customerDetailsInfo, $customerPanFileInfo, $customerBankProofFileInfo, $customerId)
    {
        $this->db->where('ID', $customerId);
        $this->db->update('customers', $customerInfo);
		
		$this->db->where('CustomerID', $customerId);
        $this->db->update('customerinformation', $customerDetailsInfo);
		
		if($customerPanFileInfo['PanCardFile']!=''){
			$this->db->where('CustomerID', $customerId);
			$this->db->update('customerpancardfile', $customerPanFileInfo);
		}
		
		if($customerBankProofFileInfo['BankProofFile']!=''){
			$this->db->where('CustomerID', $customerId);
			$this->db->update('customerbankprooffile', $customerBankProofFileInfo);
		}
		
        return TRUE;
    }
	
	/**
     * This function is used to check whether  customer is already existing or not
     * @param {string} $EmailAddress : This is EmailAddress
	 * @param {string} $MobileNumber : This is MobileNumber
	 * @param {string} $PanNumber : This is PanNumber
	 * @param {string} $AadharNumber : This is AadharNumber
     * @param {number} $customerId : This is customer id
     * @return {mixed} $result : This is searched result
     */
    function checkCustomerExists($EmailAddress='', $MobileNumber='', $customerId = 0)
    {
        $this->db->select("EmailAddress, MobileNumber");
        $this->db->from("customers");
		if($EmailAddress!=''){
			$this->db->where("EmailAddress", $EmailAddress);
		}else if($MobileNumber!=''){
			$this->db->where("MobileNumber", $MobileNumber);
		}
        if($customerId != 0){
            $this->db->where("ID !=", $customerId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function checkCustomerExistsNew($EmailAddress='', $MobileNumber='', $PanNumber='', $AadharNumber='', $customerId = 0)
    {
        $this->db->select("EmailAddress, MobileNumber, PanNumber, AadharNumber");
        $this->db->from("customers");
		if($EmailAddress!=''){
			$this->db->where("EmailAddress", $EmailAddress);
		}else if($MobileNumber!=''){
			$this->db->where("MobileNumber", $MobileNumber);
		}else if($PanNumber!=''){
			$this->db->where("PanNumber", $PanNumber);
		}else if($AadharNumber!=''){
			$this->db->where("AadharNumber", $AadharNumber);
		}
        if($customerId != 0){
            $this->db->where("ID !=", $customerId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function customerEntryFeesEdit($CustomerID,$customerInfo){
		$this->db->where('ID', $CustomerID);
        $this->db->update('customers', $customerInfo);
		
		return true;
	}
}
?>