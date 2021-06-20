<?php
class ProductVendorAttribute_model extends CI_Model
{	
	/**
     * This function is used to get the product product listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productVendorAttributeListingCount($searchText = '',$vendor_id,$product_id)
    {
        $this->db->select('`add_attributes`.`status` AS `status`,`add_attributes`.`id` AS `id`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`');
        $this->db->from('add_attributes');
		$this->db->join('product', 'product.id = add_attributes.product_id'); 
		$this->db->join('vendor', 'vendor.id = add_attributes.vendor_id');
		$likeCriteria = "add_attributes.product_id='".$product_id."' AND add_attributes.vendor_id='".$vendor_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND vendor.name  LIKE '%".$searchText."%'
							OR  product.name  LIKE '%".$searchText."%'";
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
    function productVendorAttributeListing($searchText = '', $page = '', $segment = '',$vendor_id ,$product_id)
    {
      $this->db->select('`add_attributes`.`status` AS `status`,`add_attributes`.`id` AS `id`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`');
        $this->db->from('add_attributes');
		$this->db->join('product', 'product.id = add_attributes.product_id'); 
		$this->db->join('vendor', 'vendor.id = add_attributes.vendor_id');
		$likeCriteria = "add_attributes.product_id='".$product_id."' AND add_attributes.vendor_id='".$vendor_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND vendor.name  LIKE '%".$searchText."%'
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
    function addNewProductVendorAttribute($productVendorAttributeInfo)
    {
        $this->db->trans_start();
        $this->db->insert('add_attributes', $productVendorAttributeInfo);
        
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
    function changeStatusProductVendorAttribute($id, $productVendorAttributeInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('add_attributes', $productVendorAttributeInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getProductVendorAttributeInfo($id)
    {
        $this->db->select('*');
        $this->db->from('add_attributes');
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
	
	/**
     * This function is used to update the vendor product information
     * @param array $id : This is vendor product updated information
     * @param number $id : This is vendor product id
     */
    function editProductVendorAttribute($productVendorAttributeInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('add_attributes', $productVendorAttributeInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor product is already existing or not
     * @param {string} $name : This is vendor product name
     * @param {number} $id : This is vendor product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductVendorAttributeExists($category_id, $product_id, $id = 0)
    {
        $this->db->select("*");
        $this->db->from("`add_attributes`");
        $this->db->where("`product_id`='".$product_id."'");
        if($id != 0){
            $this->db->where("`id` !='".$id."'");
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getViewDetails($id){
		$this->db->select('`add_attributes`.`id` AS `id`,`add_attributes`.`product_id` AS `product_id`,`add_attributes`.`vendor_id` AS `vendor_id`,`add_attributes`.`attribute_id` AS `attribute_id`,`add_attributes`.`value` AS `value`,`add_attributes`.`type` AS `type`,`add_attributes`.`price` AS `price`,`add_attributes`.`created_by` AS `created_by`,`add_attributes`.`updated_by` AS `updated_by`,`add_attributes`.`created_on` AS `created_on`,`add_attributes`.`updated_on` AS `updated_on`,`product`.`name` AS `product_name`,`vendor`.`name` AS `vendor_name`,`attribute`.`name` AS `attribute_name`');
        $this->db->from('add_attributes');
		$this->db->join('product', 'product.id = add_attributes.product_id'); 
		$this->db->join('vendor', 'vendor.id = add_attributes.vendor_id');
		$this->db->join('attribute', 'attribute.id = add_attributes.attribute_id');
		$this->db->where('add_attributes.id', $id);
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>