<?php
class ProductVendorUnit_model extends CI_Model
{	
	/**
     * This function is used to get the product product vendor unit count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productVendorUnitListingCount($searchText = '',$vendor_id,$product_id)
    {
        $this->db->select('`product_vendor_unit`.`status` AS `status`,`product_vendor_unit`.`id` AS `id`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`,`unit`.`name` AS `unit_name`,`unit`.`id` AS `unit_id`');
        $this->db->from('product_vendor_unit');
		$this->db->join('product', 'product.id = product_vendor_unit.product_id'); 
		$this->db->join('vendor', 'vendor.id = product_vendor_unit.vendor_id');
		$this->db->join('unit', 'unit.id = product_vendor_unit.unit_id');
		$likeCriteria = "product_vendor_unit.product_id='".$product_id."' AND product_vendor_unit.vendor_id='".$vendor_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND vendor.name  LIKE '%".$searchText."%'
							OR  unit.name  LIKE '%".$searchText."%'
							OR  product.name  LIKE '%".$searchText."%'";
        }
		$this->db->where($likeCriteria);
        //$this->db->where('Status', '1');
        $query = $this->db->get();
		//echo $this->db->last_query(); die();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the vendor product vendor unit
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function productVendorUnitListing($searchText = '', $page = '', $segment = '',$vendor_id ,$product_id)
    {
      $this->db->select('`product_vendor_unit`.`status` AS `status`,`product_vendor_unit`.`id` AS `id`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`,`unit`.`name` AS `unit_name`,`unit`.`id` AS `unit_id`');
        $this->db->from('product_vendor_unit');
		$this->db->join('product', 'product.id = product_vendor_unit.product_id'); 
		$this->db->join('vendor', 'vendor.id = product_vendor_unit.vendor_id');
		$this->db->join('unit', 'unit.id = product_vendor_unit.unit_id');
		$likeCriteria = "product_vendor_unit.product_id='".$product_id."' AND product_vendor_unit.vendor_id='".$vendor_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND vendor.name  LIKE '%".$searchText."%'
							OR  unit.name  LIKE '%".$searchText."%'
							OR  product.name  LIKE '%".$searchText."%'";
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
    function addNewProductVendorUnit($productVendorUnitInfo)
    {
        $this->db->trans_start();
        $this->db->insert('product_vendor_unit', $productVendorUnitInfo);
        
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
    function changeStatusProductVendorUnit($id, $productVendorUnitInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('add_attributes', $productVendorUnitInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getProductVendorUnitInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product_vendor_unit');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getVendorProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('vendor_product');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	function getVendorInfo($id)
    {
        $this->db->select('*');
        $this->db->from('vendor');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getUnitInfo($id)
    {
        $this->db->select('*');
        $this->db->from('unit');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the vendor product information
     * @param array $id : This is vendor product updated information
     * @param number $id : This is vendor product id
     */
    function editProductVendorUnit($productVendorUnitInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_vendor_unit', $productVendorUnitInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor product is already existing or not
     * @param {string} $name : This is vendor product name
     * @param {number} $id : This is vendor product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductVendorUnitExists($category_id, $product_id, $id = 0)
    {
        $this->db->select("*");
        $this->db->from("`product_vendor_unit`");
        $this->db->where("`product_id`='".$product_id."'");
        if($id != 0){
            $this->db->where("`id` !='".$id."'");
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getViewDetails($id){
		$this->db->select('`product_vendor_unit`.`id` AS `id`,`product_vendor_unit`.`product_id` AS `product_id`,`product_vendor_unit`.`vendor_id` AS `vendor_id`,`product_vendor_unit`.`unit_id` AS `unit_id`,`product_vendor_unit`.`per_unit_price` AS `per_unit_price`,`product_vendor_unit`.`quantity` AS `quantity`,`product_vendor_unit`.`stock` AS `stock`,`product_vendor_unit`.`created_by` AS `created_by`,`product_vendor_unit`.`updated_by` AS `updated_by`,`product_vendor_unit`.`created_on` AS `created_on`,`product_vendor_unit`.`updated_on` AS `updated_on`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`,`unit`.`name` AS `unit_name`');
        $this->db->from('product_vendor_unit');
		$this->db->join('product', 'product.id = product_vendor_unit.product_id'); 
		$this->db->join('vendor', 'vendor.id = product_vendor_unit.vendor_id');
		$this->db->join('unit', 'unit.id = product_vendor_unit.unit_id');
		$this->db->where('product_vendor_unit.id', $id);
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>