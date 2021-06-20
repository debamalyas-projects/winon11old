<?php
class ProductInformation_model extends CI_Model
{	
	/**
     * This function is used to get the product product listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productInformationListingCount($searchText = '',$product_id)
    {
        $this->db->select('product_information.id,product_information.product_id,product_information.title,product_information.description,product.name');
		$this->db->from('product_information');
		$this->db->join('product', 'product_information.product_id = product.id');
		$likeCriteria = "product_information.product_id='".$product_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND product_information.title  LIKE '%".$searchText."%'";
        }
		$this->db->where($likeCriteria);
        //$this->db->where('Status', '1');
        $query = $this->db->get();
		//echo $this->db->last_query(); die();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the vendor product listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function productInformationListing($searchText = '', $page = '', $segment = '', $product_id)
    {
       $this->db->select('product_information.id,product_information.product_id,product_information.title,product_information.description,product_information.status,product.name');
		$this->db->from('product_information');
		$this->db->join('product', 'product_information.product_id = product.id');
		$likeCriteria = "product_information.product_id='".$product_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND product.name  LIKE '%".$searchText."%'";
        }
		$this->db->where($likeCriteria);
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
     * This function is used to add new vendor product to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProductInformation($productInformationInfo)
    {
        $this->db->trans_start();
        $this->db->insert('product_information', $productInformationInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the service information
     * @param number $id : This is service id
     * @return boolean $result : TRUE / FALSE
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductInformation($id, $productInformationInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('product_information', $productInformationInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getProductInformationInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product_information');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the vendor product information
     * @param array $id : This is vendor product updated information
     * @param number $id : This is vendor product id
     */
    function editProductInformation($productInformationInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_information', $productInformationInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor product is already existing or not
     * @param {string} $name : This is vendor product name
     * @param {number} $id : This is vendor product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductInformationExists($vendor_id, $product_id, $id = 0)
    {
        $this->db->select("*");
        $this->db->from("`product_information`");
        $this->db->where("`product_id`='".$product_id."'");
        if($id != 0){
            $this->db->where("`id` !='".$id."'");
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>